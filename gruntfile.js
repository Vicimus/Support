// Gruntfile.js

// our wrapper function (required by grunt and its plugins)
// all configuration goes inside this function
module.exports = function(grunt) {

  var phpFiles = [
    'src/**/*.php',
    'tests/**/*.php'
  ];

  var standard = 'vendor/vicimus/standard/VicimusStandard,PSR2';

  // ===========================================================================
  // CONFIGURE GRUNT ===========================================================
  // ===========================================================================
  grunt.initConfig({

    // get the configuration info from package.json ----------------------------
    // this way we can use things like name and version (pkg.name)
    pkg: grunt.file.readJSON('package.json'),

    phpcs: {
      application: {
          src: phpFiles
      },
      options: {
            bin: 'vendor/bin/phpcs',
            standard: standard,
            encoding: 'utf-8',
            verbose: false,
            warningSeverity: 999,

      }
    },

      phpcbf: {
          application: {
              src: phpFiles
          },
          options: {
              bin: "vendor/bin/phpcbf",
              standard: standard,
              encoding: "utf-8",
              noPatch: false
          }
      },
    phpunit: {
        classes: {
            dir: ''

        },
        options: {
            bin: './vendor/bin/phpunit',
            colors: true
        }
    },

    phpmd: {
      application: {
        dir: 'src/'
      },
      options: {
        rulesets: 'codesize,cleancode,unusedcode',
        reportFormat: 'text',
      }
    },

    watch: {

      files: phpFiles.concat(['tests/**/*.php']),
      tasks: ['phpcs', 'phpunit']
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-phpcs');
  grunt.loadNpmTasks('grunt-phpcbf');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-phpmd');

  grunt.registerTask('default', ['phpcs', 'phpunit']);
};
