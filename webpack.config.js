const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: {
        app    : ["./assets/src/app.js"],
        critical: ["./assets/src/critical.js"],
    },
    output   : {
        filename: "[name].js",
        path    : path.resolve(__dirname, "./assets/dist"),
        clean   : true,
    },
    plugins  : [
        new MiniCssExtractPlugin({
            filename: "[name].css"
        })
    ],
    cache    : true,
    module   : {
        rules: [
            {
                test: /\.css$/i,
                use : [
                    MiniCssExtractPlugin.loader,
                    {
                        loader : "css-loader",
                        options: {
                            // url: false
                        }
                    },
                    "postcss-loader"
                ],
            },
            {
                test   : /\.js$/,
                exclude: /(node_modules)/,
                use    : {
                    loader : "babel-loader",
                    options: {
                        presets: ["@babel/preset-env"]
                    }
                }
            },
        ]
    },
};
