$(function () {
  let sidebar = $('.sidebar'),
    allDropdown = $('.sidebar-dropdown'),
    width = sidebar.width();

  function hideSidebar() {
    if (!sidebar.hasClass('hidden')) {
      sidebar.one('transitionend', function () {
        sidebar.addClass('hidden');
      });
      sidebar.width(0);
    }
  }
  function showSidebar() {
    sidebar.removeClass('hidden');
    sidebar.width(width);
  }
  function dropdown() {
    let parent = $(this).parent('.sidebar-dropdown');
    if (parent.hasClass('active')) {
      parent.removeClass('active');
    } else {
      allDropdown.removeClass('active');
      parent.addClass('active');
    }
  }

  $('#btn-hide, .btn-sidebar-close').on('click', hideSidebar);
  $('#btn-show, .btn-sidebar-show').on('click', showSidebar);
  $('.sidebar-dropdown a').on('click', dropdown);
});
