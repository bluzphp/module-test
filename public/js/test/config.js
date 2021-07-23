require.config({
    paths: {
        pager: './test/pager',
        // see more at https://cdnjs.com/
        underscore: '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore',
        backbone: '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone',
        'react': '//cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development',
        'react-dom': '//cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development',
        'redux': '//cdnjs.cloudflare.com/ajax/libs/redux/4.1.0/redux',
        'react-redux': '//cdnjs.cloudflare.com/ajax/libs/react-redux/7.2.4/react-redux'
    },
    shim: {
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        'react': {
            exports: 'React'
        },
        'react-dom': {
            deps: ['react'],
            exports: 'ReactDOM'
        },
        'react-redux': {
            deps: ['react', 'redux'],
            exports: 'ReactRedux'
        },
        'pager': {
            deps: ['react'],
            exports: 'Pager'
        },
        'underscore': {
            exports: '_'
        }
    }
});
