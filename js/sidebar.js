var url = window.location.href;
// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
return this.href == url;
}).parent().addClass('active').css('background-color', '#d2d6de');
// for treeview
$('ul.treeview-menu a').filter(function() {
return this.href == url;
}).closest('.treeview').addClass('active').css('background-color', '#d2d6de');
$(function () {
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
});