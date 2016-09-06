jQuery(function($) {
     $('div.btn-group[data-toggle-name]').each(function(){
            var group   = $(this);
			var hidden  = $('input[name=sell_method]');
            var type    = group.attr('data-toggle');
			if(hidden.val() == 0)
			{
				var data = $('tr.goodtype td:nth-child(2)').html();
				var filename = 'Товар (файл):';
			}
			if(hidden.val() == 1)
			{
				var data = '<textarea name="goods" cols="40" rows="10" class="form-control"></textarea>';
				var filename = $('tr.goodtype td:nth-child(1)').html();
			}
            $('label', group).each(function() {
				var input = $(this);
                input.on('click', function() {
                    hidden.val(input.attr('data-id'));
					if(input.attr('data-id') == 0)
					{
						$('tr.goodtype td:nth-child(1)').text('Товар (строки):');
						$('tr.goodtype td:nth-child(2)').html(data);
					}
					
					if(input.attr('data-id') == 1)
					{
						$('tr.goodtype td:nth-child(1)').html(filename);
						$('tr.goodtype td:nth-child(2)').html('<input type="file" name="userfile" size="20" class="form-control"/>');
					}
                });
                

            });
    });
});

