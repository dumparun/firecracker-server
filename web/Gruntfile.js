/**
 * Standard Grunt File, for executing tasks like CSS minnification, JS
 * Minnification
 * 
 * @author Maganiva
 */

module.exports = function(grunt) {

	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),

		cssmin : {
			compress : {
				files : {
					'themes/default/css/style.customer.1.1.0.1.min.css' : [
							'themes/default/css/style-customer.css',
							'themes/default/css/style-main.css' ],
					'themes/default/css/style-admin-vendor.1.1.0.1.min.css' : [
							'themes/default/css/style-main.css',
							'themes/default/css/style-admin-vendor.css' ],
					'themes/default/css/tp.1.1.0.1.min.css' : [
							'themes/default/css/jquery.loadmask.css',
							'themes/default/css/jkmegamenu.css',
							'themes/default/css/jquery-ui-1.10.css',
							'themes/default/css/msgBoxLight.css',
							'themes/default/css/chosen.css',
							'themes/default/css/font-awesome.min.css',
							'themes/default/css/multi-select.css' ]
				}
			}
		},

		uglify : {
			compress : {
				drop_console : true,
				files : {
					'js/thirdparty/prod/plugin.minifiedfiles.1.1.0.1.js' : [ 'js/thirdparty/dev/*.js' ],
					'themes/default/thirdpartypackage/tp.minifiedfiles.1.1.0.1.js' : [ 'themes/default/thirdpartypackage/jqueryMsgBox/jquery.msgBox.js',
																				'themes/default/thirdpartypackage/jquery.ui/jquery-ui-1.10.min.js',
																				'themes/default/thirdpartypackage/chosen/chosen.jquery.js'],
					'js/custom/prod/custom.min.1.1.0.1.js' : [ 'js/custom/*.js' ]
				}
			}
		},
		jshint : {
					options : {
						globals : {
							jQuery : true,
							console : false,
							module : true,
							document : true
						}
					},
					ignore_warning : {
						options : {
							'-W100' : true,
						},
						files : {
							src : [ 'js/custom/order.js'],
						},
					},
				}
	});

	// Load the plugin that provides the "Lint" task.
	grunt.loadNpmTasks('grunt-contrib-jshint');

	// Load the plugin that provides the "CSS Minification" task.
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Load the plugin for JS Minnification
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Prod Task
	grunt.registerTask('prod', [ 'cssmin', 'uglify' ]);

	// Linting Task
	grunt.registerTask('lint', [ 'jshint' ]);

	// Default task(s).
	grunt.registerTask('default', [ 'prod' ]);
};