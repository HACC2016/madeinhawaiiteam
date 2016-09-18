var webpack = require('webpack')

module.exports = {
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel'
      }
    ]
  },
  output: {
    path: __dirname + "/js",
    filename: "bundle.js"
  }
}
