// 引入 gulp
var gulp = require("gulp");

// 引入 gulpins
var concat = require("gulp-concat"),
	clean = require("gulp-clean"),
	browserSync = require("browser-sync"),
	uglify = require("gulp-uglify"),
  sendmail = require("gulp-mailgun");


// 自动刷新 browser-sync start
gulp.task('browser',function(){
  browserSync({
    // host: 172.16.157.1,
    port: 8082,
    open: true,
    // 路径显示/d 开始
    startPath: "/d",
    //timestamps:false,
    server: {
      directory: true,
      routes: {
        '/d': "./dist/new.html"
      },
      middleware: function(req,res,next){
        console.log("中间件");
        next();
      },
      baseDir: './'
    },
    // 指定浏览器
    // browser: "google chrome" // 或  ["google chrome","firefox"]
    // 延迟刷新，默认0
    reloadDelay: 1000,
    // 是否载入css修改，默认true
    injectChanges: false
  });
});
gulp.task('bro',function(){
  gulp.src('./dist/**')
  .pipe(browserSync.reload({stream:true}));
});
gulp.task('default',['bro','browser'],function(){
  gulp.watch('./dist/**',['bro']);
});
// 自动刷新 browser-sync end



// 发送邮件 mailgun start
gulp.task('sendmail', function () {
  gulp.src( '*/*.html') // 发送的emd邮件的path
  .pipe(sendmail({
    key: 'key-076ab9815f2ce6118165a7c6943eba3b', // Mailgun API key
    sender: 'postmaster@sandboxe70e9a862d2f43f6bb50cb35a50b04b7.mailgun.org', // mailgun提供的邮件发送账号
    recipient: '630999015@qq.com',
    subject: 'This is a 测试 email' // 邮件标题
  }));
});
// 发送邮件 mailgun end
