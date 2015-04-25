// 包装函数
module.exports = function(grunt){
	// 初始化任务配置
	grunt.initConfig({
		// 读取 pakage.json 位置文件并存储在 pkg 属性中
		pkg : grunt.file.readJSON("package.json"),

		// 创建一个任务
		uglify : {
			options : {
				// 生成注释并插入到输出文件顶部
				banner : "/* <%= pkg.name %> <%= grunt.template.today('dd-mm-yyyy') %> */ \n",
				// 定义分割合并文件的字符
				separator : ";"
			},
			// 创建该任务的一个目标
			dist : {
				// 待拼接的文件
				src : ["src/**/*.js"],
				// 生成的文件位置
				dest : "dist/<%= pkg.name %>.js"
			},
			// 创建该任务的另一个目标
			build : {
				// 待拼接的文件
				src : ["src/**/*.js"],
				// 生成的文件位置
				dest : "dist/<%= pkg.name %>.min.js"
			}
		}
	});


	// 任务加载
	grunt.loadNpmTasks("grunt-contrib-uglify");

	// 自定义任务
	grunt.registerTask("default",["uglify"]);
}
