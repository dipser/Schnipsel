const path = require('path');

module.exports = {
    mode: 'production',
    //watch: true,
    watchOptions: {
        ignored: /node_modules/,
        aggregateTimeout: 200, // after build
        poll: 1000 // every
    },
    entry: {
        main: ['./main.js', './main.scss']
    },
    output: {
        path: path.resolve(__dirname, 'assets'), 
        filename: 'js/[name].min.js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [],
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: 'css',
                            name: '[name].min.css'
                        }
                    },
                    'sass-loader'
                ]
            }
        ]
    }
};
