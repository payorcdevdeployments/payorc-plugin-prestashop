/**
 * 2007-2025 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2025 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */

$(document).ready(function () {
  var replaced = 1;
  if ($("#payment-confirmation").length)
    var cardButton = document.querySelector(
      "#payment-confirmation button[type=submit]"
    );
  else return;

  var modal = document.getElementById("payorc-modal");
  var span = document.getElementsByClassName("close")[0];
  span.onclick = function () {
    modal.style.display = "none";
    $("#payorc-loader").hide();
    document.getElementById("pay_link").src = "";
  };

	$(document).on("click", "#payorc-modal .modal-content span.close", function(e) {
		$("#payorc-modal").hide();
    $("#payorc-loader").hide();
    document.getElementById("pay_link").src = "";
		$("#payorc-ajax-loader").hide();
		$("#payment-confirmation button[type=submit]").prop(
			"disabled",
			false
		);
	})

  if (payorc_allow_cards > 0 && $("#payorc-payment-form").length) {
    cardButton.addEventListener("click", function (ev) {
      if (
        $("input[name=payment-option]:checked").data("module-name") != "payorc"
      )
        return false;

      var payorc_pm = document.getElementById("selected_pm").value;
      var quickPay = payorc_pm != 1 ? 1 : 0;

      event.preventDefault();
      $("input[name=payment-option]:checked").focus();
      $("#payorc-ajax-loader,#payorc-payment-form").toggle();
      $("#payment-confirmation button[type=submit]").prop("disabled", true);
			var platform = getPlatform();
			var browserName = getBrowser();
			var browserVersion = navigator.userAgent.match(/(Chrome|Firefox|Safari|Edg|OPR)\/([\d.]+)/)?.[2] || "Unknown";
      if(replaced == 1) {
        customer_details = JSON.parse(customer_details.replaceAll("&quot;", '"'));
        replaced = 0;
      }
      
      var ajax_data = {
        cart_id: ps_cart_id,
        ajax: true,
        order_details: order_items,
        billing_details: billing_address,
        customer_details: customer_details,
        shipping_details: ship_address,
        success_url: validation_url,
        order_cancel_url: cancel_url,
        capture_method: payorc_capture_method,
        platform: platform,
        browserName: browserName,
        browserVersion: browserVersion,
      };

      $.ajax({
        type: "POST",
        url: ajax_payment,
        data: ajax_data,
        async: false,
        success: function (resp) {
          var data = JSON.parse(resp);
          if (data.code == 2) {
            if (payorc_allow_cards == 1) {
							attachEvent();
              $("#payorc-modal").show();
              $("#payorc-loader").show();
              setTimeout(function() {
                $("#payorc-loader").hide();
              }, 3000);
              document.getElementById("pay_link").src = data.payorc_gate.iframe_link;
            } else {
              window.location.href = data.payorc_gate.payment_link;
            }
          } else {
            var error = JSON.parse(data.error);
            $("#payorc-payment-form #card-errors").text(error.message);
            $("#payorc-payment-form").show();
            $("#payorc-ajax-loader").hide();
            setTimeout(function () {
              $("#payment-confirmation button[type=submit]").prop(
                "disabled",
                false
              );
            }, 200);
          }
        },
        error: function (jqXHR, exception) {
          return false;
        },
      });
    });
  }
});

function attachEvent() {
  var eventMethod = window.addEventListener
    ? "addEventListener"
    : "attachEvent";
  var eventer = window[eventMethod];
  var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
  eventer(
    messageEvent,
    function (e) {
      console.log(JSON.parse(e.data));
      result = JSON.parse(e.data);
      if (result["status"] == "SUCCESS") {
        handleValidation(result);
      } else if (result["status"] == "CANCELLED") {
        $("#payorc-loader").hide();
        document.getElementById("pay_link").src = "";
        setTimeout(function () {
          $("#payorc-modal").hide();
          $("#payorc-ajax-loader").hide();
          $("#payment-confirmation button[type=submit]").prop(
            "disabled",
            false
          );
        }, 200);
      } else if (result["status"] == "FAILED") {
        handleValidation(result);
      }
    },
    false
  );
}

function getPlatform() {
  const ua = navigator.userAgent || navigator.vendor || window.opera;
  if (/android/i.test(ua)) {
    return "Android";
  }
  if (/iPad|iPhone|iPod/.test(ua) && !window.MSStream) {
    return "iOS";
  }
  if (/Win/.test(navigator.platform)) {
    return "Windows";
  }
  if (/Mac/.test(navigator.platform)) {
    return "Mac";
  }
  if (/Linux/.test(navigator.platform)) {
    return "Linux";
  }
  return "Unknown";
}

function getBrowser() {
  const ua = navigator.userAgent;
  if (ua.includes("Chrome") && !ua.includes("Edg") && !ua.includes("OPR")) return "Chrome";
  if (ua.includes("Firefox")) return "Firefox";
  if (ua.includes("Safari") && !ua.includes("Chrome")) return "Safari";
  if (ua.includes("Edg")) return "Edge";
  if (ua.includes("OPR") || ua.includes("Opera")) return "Opera";
  return "Unknown";
}

function handleValidation(data) 
{
	data['ajax'] = 1;
	$.ajax({
		type: "POST",
		url: validation_url.replace(/&amp;/g, "&"),
		data: data,
		async: false,
		success: function (resp) {
			var data = JSON.parse(resp);
			if (data.order_conf_url) {
				setTimeout(function(){
					location.replace = data.order_conf_url;
					window.location.href = data.order_conf_url;
				}, 1000);
			} else {
				var error = JSON.parse(data.error);
				$("#payorc-payment-form #card-errors").text(error.message);
				$("#payorc-payment-form").show();
				$("#payorc-ajax-loader").hide();
				setTimeout(function () {
					$("#payment-confirmation button[type=submit]").prop(
						"disabled",
						false
					);
				}, 200);
			}
		},
		error: function (jqXHR, exception) {
			return false;
		},
	});
}