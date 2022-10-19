import "./scss/style.scss"
// import "bootstrap/js/src/dropdown"
import "bootstrap/js/src/collapse"

$(function() {
    // Sidebar toggle behavior
    $('#sidebarCollapse').on('click', function() {
      $('#sidebar, #content').toggleClass('active');
    });
  });