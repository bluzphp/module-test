
require.config({
	paths: {
		"pager": "./test/pager",
    text: './vendor/text',
    jsx: './vendor/jsx',
    JSXTransformer: './vendor/JSXTransformer',
		// see more at https://cdnjs.com/
		"underscore": '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore',
		"backbone": '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone',
		"react": '//cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react',
		"react-dom": '//cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react-dom',
		"redux": '//cdnjs.cloudflare.com/ajax/libs/redux/3.5.2/redux',
		"react-redux": '//cdnjs.cloudflare.com/ajax/libs/react-redux/4.4.5/react-redux'
	},
	shim: {
		"backbone": {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		},
		"react": {
			exports: 'React'
		},
		"react-dom": {
			deps: ['react'],
			exports: 'ReactDOM'
		},
		"react-redux": {
			deps: ['react', 'redux'],
			exports: 'ReactRedux'
		},
		"pager": {
			deps: ['react'],
			exports: 'Pager'
		},
		"underscore": {
			exports: '_'
		}
	},
  jsx: {
    fileExtension: '.jsx'
  }
});
