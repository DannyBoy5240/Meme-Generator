/** add popup for search form */
jQuery(function($){
  $('.popup-with-form').magnificPopup({
    type: 'inline',
    preloader: false,
    focus: '.fl-search-input',

    // When element is focused, some mobile browsers in some cases zoom in
    // It looks not nice, so we disable it:
    callbacks: {
      beforeOpen: function() {
        $('body').addClass('search-form');
        $('#footer #search').hide();
        $('#header #search').hide();
        if($(window).width() < 700) {
          this.st.focus = false;
        } else {
          this.st.focus = '.fl-search-input';
        }
      },
      close: function() {
        $('body').removeClass('search-form');
        $('#footer #search').css("display", "none !important");
        $('#header #search').css("display", "none !important");
      }
    }
  });

  $("#shiftnav-toggle-main-button").on('click', function () {
    //alert('open');
    //$('.shiftnav-overlay').css("display", "block");
  });

  
  //disable partner donate button until a selection is made
  $('.donate-partners a.ta-button').addClass('disabled');

  $('.donate-partners a.ta-button').click(function(e) {
    e.preventDefault();
    //do other stuff when a click happens
  });

  function updateDonateEnabled() {
    if (verifySelect()) {
      $('.donate-partners a.ta-button').removeClass('disabled');
      $('.donate-partners a.ta-button').click(function(){ // on submit button click
            var urldata = $('#donate-partner-options :selected').val(); // get the selected  option value
            window.open(urldata) // open a new window. here you need to change the url according to your wish.
        });
    } else {
      $('.donate-partners a.ta-button').click(function(e) {
        e.preventDefault();
        //do other stuff when a click happens
      });
    }
}

function verifySelect() {
    if ($('#donate-partner-options').val() != '') {
        return true;
    } else {
        return false
    }
}

  $('#donate-partner-options').change(updateDonateEnabled);

});