import "./scss/back.scss"
// import "bootstrap/js/src/dropdown"
import "bootstrap/js/src/collapse"

$(function() {
    // Sidebar toggle behavior
    $('#sidebarCollapse').on('click', function() {
      $('#sidebar').toggleClass('open');
    });

    $('#buttonCollapse').on('click', function() {
      $('#sidebar').removeClass('open');
    });
  });

