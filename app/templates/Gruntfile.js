module.exports = function( grunt ) {

	require('load-grunt-tasks')(grunt);

	var bannerTemplate = '/**\n' +
		' * //<%= pkg.title //%> - v//<%= pkg.version //%> - //<%= grunt.template.today("yyyy-mm-dd") //%>\n' +
		' * //<%= pkg.homepage //%>\n' +
		' *\n' +
		' * Copyright (c) //<%= grunt.template.today("yyyy") //%>;\n' +
		' * Licensed GPLv2+\n' +
		' */\n';

	var compactBannerTemplate = '/**\n' +
		' * //<%= pkg.title //%> - v//<%= pkg.version //%> - //<%= grunt.template.today("yyyy-mm-dd") //%> | //<%= pkg.homepage //%> | Copyright (c) //<%= grunt.template.today("yyyy") //%>; | Licensed GPLv2+\n' +
		' */\n';

	// Project configuration
	grunt.initConfig( {

		pkg:    grunt.file.readJSON( 'package.json' ),


		watch:  {
			styles: {
				files: ['assets/**/*.css','assets/**/*.scss'],
				tasks: ['styles'],
				options: {
					spawn: false,
					livereload: true,
					debounceDelay: 500
				}
			},
			scripts: {
				files: ['assets/**/*.js'],
				tasks: ['scripts'],
				options: {
					spawn: false,
					livereload: true,
					debounceDelay: 500
				}
			},
			php: {
				files: ['**/*.php', '!vendor/**.*.php'],
				tasks: ['php'],
				options: {
					spawn: false,
					debounceDelay: 500
				}
			}
		},

		/**
		 * check WP Coding standards
		 * https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
		 */
		phpcs: {
			application: {
				dir: [
					'**/*.php',
					'!**/node_modules/**'
				]
			},
			options: {
				bin: '~/phpcs/scripts/phpcs',
				standard: 'WordPress'
			}
		},

		makepot: {
			dist: {
				options: {
					domainPath: '/languages/',
					potFilename: '<%= slug %>.pot',
					type: 'wp-plugin'
				}
			}
		},

		addtextdomain: {
			dist: {
				options: {
					textdomain: '<%= slug %>'
				},
				target: {
					files: {
						src: ['**/*.php']
					}
				}
			}
		}

	} );

	// Load other tasks
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-phpcs');

	// Default task.
	grunt.registerTask( 'scripts', [] );
	grunt.registerTask( 'styles', [] );
	grunt.registerTask( 'php', [ 'phpcs', 'addtextdomain', 'makepot' ] );
	grunt.registerTask( 'default', ['styles', 'scripts', 'php'] );

	grunt.util.linefeed = '\n';
};
