module.exports = function( grunt ) {

	require('load-grunt-tasks')(grunt);

	var pkg = grunt.file.readJSON( 'package.json' );

	var bannerTemplate = '/**\n' +
		' * <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
		' * <%= pkg.author.url %>\n' +
		' *\n' +
		' * Copyright (c) <%= grunt.template.today("yyyy") %>;\n' +
		' * Licensed GPLv2+\n' +
		' */\n';

	var compactBannerTemplate = '/** ' +
		'<%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %> | <%= pkg.author.url %> | Copyright (c) <%= grunt.template.today("yyyy") %>; | Licensed GPLv2+' +
		' **/\n';

	// Project configuration
	grunt.initConfig( {

		pkg: pkg,


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

		makepot: {
			dist: {
				options: {
					domainPath: '/languages/',
					potFilename: pkg.name + '.pot',
					type: 'wp-plugin'
				}
			}
		},

		addtextdomain: {
			dist: {
				options: {
					textdomain: pkg.name
				},
				target: {
					files: {
						src: ['**/*.php']
					}
				}
			}
		},

		replace: {
			version_php: {
				src: [
					'**/*.php',
					'!vendor/**',
				],
				overwrite: true,
				replacements: [ {
						from: /Version:(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
						to: 'Version:$1' + pkg.version
				}, {
						from: /@version(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
						to: '@version$1' + pkg.version
				}, {
						from: /@since(.*?)NEXT/mg,
						to: '@since$1' + pkg.version
				}, {
						from: /VERSION(\s*?)=(\s*?['"])[a-zA-Z0-9\.\-\+]+/mg,
						to: 'VERSION$1=$2' + pkg.version
				} ]
			},
			version_readme: {
				src: 'README.md',
				overwrite: true,
				replacements: [ {
						from: /^\*\*Stable tag:\*\*(\s*?)[a-zA-Z0-9.-]+(\s*?)$/mi,
						to: '**Stable tag:**$1<%= pkg.version %>$2'
				} ]
			},
			readme_txt: {
				src: 'README.md',
				dest: 'release/' + pkg.version + '/readme.txt',
				replacements: [ {
						from: /^# (.*?)( #+)?$/mg,
						to: '=== $1 ==='
					}, {
						from: /^## (.*?)( #+)?$/mg,
						to: '== $1 =='
					}, {
						from: /^### (.*?)( #+)?$/mg,
						to: '= $1 ='
					}, {
						from: /^\*\*(.*?):\*\*/mg,
						to: '$1:'
				} ]
			}
		},

		copy: {
			release: {
				src: [
					'**',
					'!assets/js/components/**',
					'!assets/css/sass/**',
					'!assets/repo/**',
					'!bin/**',
					'!release/**',
					'!tests/**',
					'!node_modules/**',
					'!**/*.md',
					'!.travis.yml',
					'!.bowerrc',
					'!.gitignore',
					'!bower.json',
					'!Dockunit.json',
					'!Gruntfile.js',
					'!package.json',
					'!phpunit.xml',
				],
				dest: 'release/' + pkg.version + '/'
			},
            svn: {
                cwd: 'release/<%= pkg.version %>/',
                expand: true,
                src: '**',
                dest: 'release/svn/'
            }
		},

		compress: {
            dist: {
                options: {
                    mode: 'zip',
                    archive: './release/<%= pkg.name %>.<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'release/<%= pkg.version %>',
                src: ['**/*'],
                dest: '<%= pkg.name %>'
            }
        },

        wp_deploy: {
            dist: {
                options: {
                    plugin_slug: '<%= pkg.name %>',
                    build_dir: 'release/svn/',
                    assets_dir: 'assets/repo/'
                }
            }
        },

        clean: {
            release: [
                'release/<%= pkg.version %>/',
                'release/svn/'
            ]
        }

	} );

	grunt.registerTask( 'scripts', [] );
	grunt.registerTask( 'styles', [] );
	grunt.registerTask( 'php', [ 'addtextdomain', 'makepot' ] );
	grunt.registerTask( 'default', ['styles', 'scripts', 'php'] );

	grunt.registerTask( 'version', [ 'default', 'replace:version_php', 'replace:version_readme' ] );
	grunt.registerTask( 'release', [ 'clean:release', 'replace:readme_txt', 'copy', 'compress', 'wp_deploy' ] );

	grunt.util.linefeed = '\n';
};
