// function loadHeader(){
//     let width = window.innerWidth;
//
//     let header = (width < 992) ? 'Mobile' : 'Desktop';
//
//     $.ajax({
//         url: '/ajax/header?headerView='+header,
//         method: 'GET',
//         success: function (data){
//             $('#header').html(data);
//             $('.dropdown-toggle').dropdown();
//         },
//     });
// }
//
// $(document).ready(function() {
//     loadHeader();
// });
//
// $(window).resize(function() {
//     loadHeader();
// });