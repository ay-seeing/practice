// 引入 gulp
var gulp = require("gulp");

// 引入 gulpins
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
var concat = require("gulp-concat"),
	clean = require("gulp-clean"),
	browserSync = require("browser-sync"),
	uglify = require("gulp-uglify");
=======
var browserSync = require("browser-sync");
>>>>>>> 3658e9cb3d3864c7be860380ff4c421aee3e9a37
=======
var browserSync = require("browser-sync");
>>>>>>> 3658e9cb3d3864c7be860380ff4c421aee3e9a37
=======
var browserSync = require("browser-sync");
>>>>>>> 3658e9cb3d3864c7be860380ff4c421aee3e9a37


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
