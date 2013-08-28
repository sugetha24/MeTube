/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */

$(document).ready(function(){
	
	ajax = false;	
	
	loadComments();
	
	$('#submit').click(function() {
		
		if (ajax)
			return false;
		
		$('#waiting').show(500);
		$('#demoForm').hide(0);
		$('#message').hide(0);
		
		ajax = true;
		
		$.ajax({
			'type' 		: 'POST',
			'url' 		: 'post.php',
			'dataType'  : 'json',
			'data' 		: {
				'type' 		 : 'post',
				'name'		 : $('#name').val(),
				'email'		 : $('#email').val(), 
				'url'		 : $('#url').val(), 
				'msg'	 	 : $('#msg').val(), 
				'parent'	 : $('#parent').val(),
				'mediaid'	 : $('#mediaid').val()
			},
			'success' 	: function(data){
				$('#waiting').hide(500);
				$('#message').removeClass().addClass((data.error === true) ? 'error' : 'success')
					.text(data.msg).show(500);
				
				if (data.error === false) {
					ajax = false;
					loadComments();
				}
			},
			'error' 	: function(XMLHttpRequest, textStatus, errorThrown) {
				$('#waiting').hide(500);
				$('#message').removeClass().addClass('error')
					.text('There was an error.').show(500);
				$('#demoForm').show(500);
			}
		});
		
		ajax = false;
		
		return false;
	});
	
	$('.replayLink').live('click', function() {
		
		if (ajax)
			return false;
		
		$('#waiting').show(500);
		$('#demoForm').hide(0);
		$('#message').hide(0);
		
		ajax = true;
		
		$.ajax({
			'type' 		: 'POST',
			'url' 		: $(this).attr('href'),
			'dataType'  : 'json',
			'data' 		: {
				'type' : 'reply'
			},
			'success' 	: function(data){
				$('#waiting').hide(500);
				if (data.error === true)
					$('#message').removeClass().addClass('error')
						.text(data.msg).show(500);
				else { 
					$('#form legend').text('Write reply to comment posted by ' + data.name + '.');
					$('#parent').val(data.id);
				}
			},
			'error' 	: function(XMLHttpRequest, textStatus, errorThrown) {
				$('#waiting').hide(500);
				$('#message').removeClass().addClass('error')
					.text('There was an error.').show(500);
				$('#demoForm').show(500);
			}
		});
		
		ajax = false;
		
		return false;
	});
});

function loadComments()
{
	
	$('#waiting').show(500);
	$('#message').hide(0);
	
	ajax = true;
	
	$.ajax({
		'type' 		: 'POST',
		'url' 		: 'comments.php',
		'dataType'  : 'html',
		'data' 		: {},
		'success' 	: function(data){
			$('#waiting').hide(500);
			$('#comments').html(data);
		},
		'error' 	: function(XMLHttpRequest, textStatus, errorThrown) {
			$('#waiting').hide(500);
			$('#message').removeClass().addClass('error')
				.text('There was an error.').show(500);
		}
	});
	
	ajax = false;
}