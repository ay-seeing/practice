module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // 拼接和组装email模块
        assemble: {
          options: {
            layoutdir: 'includes/layouts',
            partials: ['includes/**/*.hbs','includes/**/*.css'],
            flatten: true
          },
          edm: {
            src: ['includes/mails/template-1.hbs'],
            dest: 'dist/'
          }
        },

        // 通过 Mailgun 将邮件发送到你的邮箱
        mailgun: {
          mailer: {
            options: {
              key: 'key-076ab9815f2ce6118165a7c6943eba3b', // Mailgun API key
              sender: 'aysee@sandboxe70e9a862d2f43f6bb50cb35a50b04b7.mailgun.org', // mailgun提供的邮件发送账号
              recipient: '630999015@qq.com,yiyangzhang@ctrip.com,zhangyiyang_love@sina.cn', 
              // recipient: 'bigpet1991@163.com, 286030975@qq.com, hpzeng@Ctrip.com, bigpet1991@gmail.com', // 邮件接收人的地址
              subject: '重庆那啥' // 邮件标题
            },
            src: ['dist/ad_chongqing.html']   // 发送的emd邮件的path
          }
        },

        watch: {
          compile: {
            files: ['includes/**/*'],
            tasks: ['assemble']
          }
        }
    });

    // Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('assemble');
    grunt.loadNpmTasks('grunt-mailgun');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['assemble']);

    // Use grunt send if you want to actually send the email to your inbox
    grunt.registerTask('send', ['mailgun']);

};
