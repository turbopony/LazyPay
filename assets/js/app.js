var coupon = ""; 
function price_rub() {
	$('.dlrprice').each(function() {
		var price = $(this);
		price.hide();
	});
	$('.rubprice').each(function() {
		var price = $(this);
		price.show();
	});
}

function price_dlr() {
	$('.rubprice').each(function() {
		var price = $(this);
		price.hide();
	});
	$('.dlrprice').each(function() {
		var price = $(this);
		price.show();
	});
}

	function validateEmail(email){ 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

function showerr(data)
{
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'warning'
	});
}

function showmsg(data)
{
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'notice'
	});
}


function sendData() {
    //читаем данные из формы
    var email = $('input[name=email]').val();
	var countAccs = $('input[name=count]').val() || 0;
	var selectType = $('select[name=item]').val();
	var minCount = $('option[value="' + selectType + '"]').attr('data-min_order');
	var itemCount = $('option[value="' + selectType + '"]').attr('data-item_count');
	var fund = $('select[name=funds]').val();

	if (!validateEmail(email))
	{
		var err = 'Указан неверный email адрес!';
		showerr(err);
		return false;
	}
	
	if (parseInt(countAccs) < parseInt(minCount))
	{
		var err = 'Мин. кол-во для заказа: ' + minCount;
		showerr(err);
		return false;
	}
	
	if (parseInt(itemCount) < parseInt(countAccs))
	{
		var err = 'Такого количества товара нет!';
		showerr(err);
		return false;
	}

	if(coupon.length != 10 && coupon.length > 0) {
		var err = 'Неверный промо-код!';
		showerr(err);
		return false;
	}

	
	$("#loading").show();
	$.post("/order/", { email: email, count:countAccs, type: selectType, coupon:coupon, fund:fund},

	function(data) {
		try
        {
			var res = JSON.parse(data);
			if(res.ok == 'TRUE')
			{
				$('.checkpaybtn').text('Проверить');
				$('.paytable .payitem').text(res.name);
				$('.paytable .paycount').text(res.count);
				$('.paytable .payprice').text(res.price+" "+res.pay);
				$('.paytable .payfund').html(res.fund);
				$('.paytable .paybill').html(res.bill);
				$('.checkpaybtn').attr('onclick',"checkpay('" + res.check_url + "')");
				$('#paymodal').modal('toggle');
				$("#loading").hide();
			}

		if(typeof(res.error) !== "undefined" && res.error !== null) {
				$("#loading").hide();
				showerr(res.error);
			}
	
	
			if(res.pay == 'WMR' || res.pay == 'WMZ') {
				$('#keeperLink').html('<div class="alert alert-success">Если у вас WM Keeper Classic, для оплаты <a href="wmk:payto?Purse='+res.fund+'&Amount='+res.price+'&Desc='+res.bill+'&BringToFront=Y">нажмите здесь</a>.</div>');
			}
			
			
		}
		catch(err)
		{
			$("#loading").hide();
			var err = 'Настройки для этого метода оплаты неверны! \r\nСообщите продавцу об этом!';
			showerr(err);
		}
		
		
	});
            
}

function checkpay(url)
{
$('.checkpaybtn').button('loading');
$.get(url, function(data) {
  $('.checkpaybtn').button('reset');
  var res = JSON.parse(data);
  if(res.status == "ok")
  {
	$('.checkpaybtn').attr('onclick','window.location ="'+res.chkurl+'"');
	$('.checkpaybtn').text('Скачать');
  }
  else
  {
	var msg = 'Платеж не найден! Попробуйте позже.';
	showmsg(msg);
  }
});
}

$( document ).ready(function() {
  
  var inpcp;
  var svcpn;
  $('#coupon').popover({
  	html: true,
  	placement: 'left',
 	content: function() {
		inpcp = $(this).parent().find('.popover_content');
		inpcp.find('input').attr('value', coupon);
  		return inpcp.html();
  	}
  });
  $('#coupon').click(function (e) {
	svcpn = $(this).parent().find('.popover').find('input');
  	svcpn.bind("change paste keyup", function() {
       coupon = $(this).val(); 
    });
  });
  $('body').on('click', function (e) {
      $('#coupon').each(function () {
          if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			$(this).popover('hide');
          }
      });
  });
});

