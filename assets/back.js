import "./scss/back.scss"
// import "bootstrap/js/src/dropdown"
import "bootstrap/js/src/collapse"
import "ckeditor4"

$(function () {
  // Sidebar toggle behavior
  $('#sidebarCollapse').on('click', function () {
    $('#sidebar').toggleClass('open');
  });

  $('#buttonCollapse').on('click', function () {
    $('#sidebar').removeClass('open');
  });
});


ClassicEditor.create( document.querySelector( '#article_body' ) )
.then( editor => {
        console.log( editor );
} )
.catch( error => {
        console.error( error );
} );

CKFinder.setupCKEditor('#article_body');
CKEDITOR.replace('#article_body');