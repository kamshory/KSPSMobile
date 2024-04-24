$(document).ready(function(e){
  $('nav.tab-content-menu > ul > li a[href^="#"]').on('click', function(e1){
	  $(this).closest('li').siblings().removeClass('active');
	  $(this).closest('li').addClass('active');
	  var frag = $(this).attr('href');
	  if(frag.indexOf('#') > -1)
	  {
		  var frags = frag.split('#', 2);
		  frag = frags[1];
	  }
	  showTab('.content-tabs', frag);
  });
  $('.table-block').each(function(e1){
	  var table = $(this);
	  var caption = [];
	  table.find('thead tr').find('td').each(function(e2){
		  var td = $(this);
		  caption.push(td.text().trim());
	  });
	  table.find('tbody').find('tr').each(function(e3){
		  var tr = $(this);
		  var i = 0;
		  tr.find('td').each(function(e4){
			  var td = $(this);
			  var txt = $(this).text();
			  txt = txt.replace(/[\t\n]+/g,' ');
			  txt = txt.trim();
			  if(txt.length == 0)
			  {
				  $(this).html('&nbsp;');
			  }
			  td.attr('data-text', caption[i]);
			  i++;
		  });
	  });
  })
  var self = window.location.toString();
  if(self.indexOf('#') != -1)
  {
	  var frags = self.split('#', 2);
	  var frag = frags[1];
	  $('.content-tabs').find('.content-tab').css('display', 'none')
	  $('nav.tab-content-menu > ul > li a[href="#'+frag+'"]').click();
  }

});
function showTab(tabs, tab)
{
	$(tabs).find('[data-id="'+tab+'"]').siblings().fadeOut(200, function(e) {
		// Animation complete
		$(tabs).find('[data-id="'+tab+'"]').siblings().removeClass('active').css('display', 'none');
		setTimeout(function(){
		$(tabs).find('[data-id="'+tab+'"]').addClass('active').fadeIn(200);
		}, 100);
	});

}
function showLoading()
{
	$('.progress-bar-loading').css({'display':'block'});
}