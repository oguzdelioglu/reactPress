(function($) {
var nowDate = new Date (),
date = new Date ( nowDate );
date.setMinutes(nowDate.getMinutes() + 5);
console.log("Date:"+date.getTime());
$('.ads').on('click', function () {
  console.log("AD Clicked");
  localStorage.setItem("date", date.getTime());
});
var prevDate = localStorage.getItem("date");
console.log("Prev Date:"+prevDate);
console.log("Diff:"+ (prevDate));
if (!prevDate || prevDate < nowDate.getTime()){
  console.log("AD Showed");
  $('.ads').show();
}
})(jQuery);