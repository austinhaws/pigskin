const path = require('path');

// where does source live
const APP_DIR = path.resolve(__dirname, 'js/react');

// where does compiled code go
const BUILD_DIR = path.resolve(__dirname, 'js/bundles');

// put the scss and css into a single file
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const cssExtract = new ExtractTextPlugin({
	filename: "main.css"
});

// tell it what file to starting compiling on and what to call it when done
const config = {
	entry: {
		app: APP_DIR + "/view/app/App.jsx",
	},
	output: {
		path: BUILD_DIR,
		filename: "[name].bundle.js"
	},

	// use babel loader
	module : {
		rules : [
			// looking in app for files
			{
				test : /\.jsx?/,
				include : APP_DIR,
				loader : "babel-loader"
			},
			// SCSS and Single CSS file magic
			{
				test: /\.scss$/,
				use: ExtractTextPlugin.extract({
					fallback: "style-loader",
					use: [
						{
							loader: "css-loader",
							options: {
								sourceMap: true
							}
						},
						{
							loader: "postcss-loader",
							options: {
								sourceMap: true
							}
						},
						{
							loader: "sass-loader",
							options: {
								sourceMap: true
							}
						},
					]
				})
			}

		]
	},

	plugins: [
		cssExtract,
	],
};

module.exports = config;
