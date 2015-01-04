// 引入 gulp
var gulp = require("gulp");

// 引入 gulpins
var concat = require("gulp-concat"),
	clean = require("gulp-clean"),
	browserSync = require("browser-sync"),
	reload = browserSync.reload;
	uglify = require("gulp-uglify");


// 自动刷新 browser-sync start
gulp.task('browser',function(){
  browserSync({
    // host: 172.16.157.1,
    port: 8082,
    open: true,
    startPath: "/d",
    //timestamps:false,
    server: {
      //directory: true,
      routes: {
        '/d': "./dist/index.html"
      },
      middleware: function(req,res,next){
        console.log("中间件");
        next();
      },
      baseDir: './'
    }
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
