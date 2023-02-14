module.exports = function(grunt) {

  require('google-closure-compiler').grunt(grunt);

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    cssmin: {
      options: {
        banner:
          "/*\n"+
           " * ShiftNav \n" +
           " * http://shiftnav.io \n" +
           " * Copyright 2013-2015 Chris Mavricos, SevenSpark \n" +
           " */"
      },
      minify: {
        files: {
          'assets/css/shiftnav.min.css' : ['assets/css/shiftnav.css'],
          'pro/assets/css/shiftnav.min.css' : ['pro/assets/css/shiftnav.css']
        }
      }
      /*
      minify: {
          expand: true,
          cwd: 'assets/css/',
          src: ['ubermenu.css'],
          dest: 'assets/css/',
          ext: '.min.css'
        }
      */
    },

    // 'closure-compiler': {
    //   frontend: {
    //     closurePath: '/usr/local/opt/closure-compiler/libexec/closure-compiler-v20170521.jar',
    //     js: 'assets/js/*.js',
    //     jsOutputFile: 'assets/js/shiftnav.min.js',
    //     maxBuffer: 500,
    //     options: {
    //       compilation_level: 'SIMPLE_OPTIMIZATIONS',
    //       language_in: 'ECMASCRIPT5_STRICT'
    //     }
    //   }
    // },
    'closure-compiler': {
      shiftnavjs: {
        files: {
          'assets/js/shiftnav.min.js': ['assets/js/shiftnav.js']
        },
        options: {
          //js: ['assets/js/shiftnav.js'],
          compilation_level: 'SIMPLE_OPTIMIZATIONS',
          //js_output_file: 'assets/js/shiftnav.min.js',
          output_wrapper: '',
          debug: false,
          language_in: 'ECMASCRIPT5_STRICT',
          language_out: 'ECMASCRIPT5_STRICT'
        }
      }
      //my_target: {
        // files: {
        //   'assets/js/shiftnav.min.js': ['assets/js/*.js']
        // }
        // // options: {
        //   compilation_level: 'SIMPLE',
        //   language_in: 'ECMASCRIPT5_STRICT',
        //   create_source_map: 'assets/js/shiftnavtest.min.js.map'//,
        //   //output_wrapper: '(function(){\n%output%\n}).call(this)\n//# sourceMappingURL=output.min.js.map'
        // }
      //}
    },

    less: {
      development: {
        options: {
          compress: false,
        },
        files: [
          {
            "assets/css/shiftnav.css": "assets/css/shiftnav.less"
          },
          {
            "pro/assets/css/shiftnav.css": "pro/assets/css/shiftnav.less"
          },
          //copy pro to light
          {
            expand: true,
            cwd: 'pro/assets/css/skins/',
            src: ['light.less'],
            dest: 'assets/css/skins',
            ext: '.css'
            // target.css file: source.less file
            //"pro/assets/css/skins/blackwhite2.css": "pro/assets/css/skins/blackwhite2.less"
          },
        ]
      }
    },

    makepot: {
      target: {
        options: {
          mainFile: 'shiftnav.php',
          domainPath: '/languages',
          potFilename: 'shiftnav.pot',
          // include: [
          //   'path/to/some/file.php'
          // ],
          type: 'wp-plugin', // or `wp-theme`
          potHeaders: {
            poedit: true
          }
        }
      }
    }
  });



  // Load the plugin that provides the "uglify" task.
  //grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks( 'grunt-contrib-less' );
  grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
  //grunt.loadNpmTasks( 'grunt-closure-compiler' );
  grunt.loadNpmTasks( 'grunt-wp-i18n' );

  grunt.registerTask('css', ['less','cssmin']);
  //grunt.registerTask('css', ['less']);

  grunt.registerTask('compile', ['closure-compiler']);

  // Default task(s).
  grunt.registerTask('default', ['less','closure-compiler','makepot']);

};
