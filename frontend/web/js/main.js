$(document).ready(function(){

  $('#templates-aside').click(function (e) {
    e.preventDefault();
    $('.enabled-aside').removeClass('enabled-aside');
    $('#template-side').toggleClass('enabled-aside')
  });

  $('#catalog-aside').click(function (e) {
     e.preventDefault();
      $('.enabled-aside').removeClass('enabled-aside');
     $('#catalog-side').toggleClass('enabled-aside')
  });

  $('.filter-templates').on('submit',function (e) {
        e.preventDefault();
  });

});
