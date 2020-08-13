const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    mode: 'production',
    //watch: true,
    watchOptions: {
        ignored: /node_modules/,
        aggregateTimeout: 200, // after build
        poll: 1000 // every
    },
    entry: {
        main: ['./assets/js/main.js', './assets/css/main.scss']
    },
    output: {
        path: path.resolve(__dirname, 'assets'), 
        filename: 'js/[name].min.js',
    },
    module: {
        rules: [
            // Running Babel on JS files. https://www.thebasement.be/working-with-babel-7-and-webpack/
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
                        presets: [
                            [
                                "@babel/preset-env", {
                                    "useBuiltIns": "usage",
                                    "debug": true
                                }
                            ]
                        ],
                        plugins: [
                            //'lodash',
                            '@babel/plugin-transform-runtime'
                        ]
					}
				}
            },
            {
                test: /\.vue$/,
                use: 'vue-loader'
            },
            {
                test: /\.(scss)$/,
                //exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: 'css',
                            name: '[name].min.css'
                        }
                    },
                    /* {
                        loader: 'style-loader', // inject CSS to page
                    }, */
                    {
						loader: 'extract-loader'
					},
                    {
                        loader: 'css-loader?-url', // translates CSS into CommonJS modules
                    },
                    {
                        loader: 'postcss-loader', // Run post css actions
                        options: {
                            plugins: function () { // post css plugins, can be exported to postcss.config.js
                                return [
                                    require('precss'),
                                    require('autoprefixer')
                                ];
                            }
                        }
                    },
                    {
                        loader: 'sass-loader' // compiles Sass to CSS
                    },
                    
                ]
            },
        ]
    },
    plugins: [
        new VueLoaderPlugin(),
    ]
};
