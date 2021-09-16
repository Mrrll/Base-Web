// TODO: Archivo de Configuracion Webpack ...

// ? Importamos plugines ...
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { VueLoaderPlugin } = require('vue-loader');
require("babel-polyfill");

// *: Construimos el modulo de exportacion ...
module.exports = {
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css', // !: Definimos el nombre [name] del Entry para el archivo css ...
            chunkFilename: '[id].css'
        }), // *: Instanciamos el Plugin ...
        new VueLoaderPlugin()
    ],
    entry: {
        app: ['babel-polyfill','./src/resources/Js/index.js', './src/resources/Css/Style.css'] // !: Colocamos dos arhivos para un punto de entrada ...
    },
    output: {
        filename: '[name].js', // !: Definimos el nombre [name] del Entry para el archivo js ...
        path: path.resolve(__dirname, 'public/') // !: Definimos la ruta de salida ...
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/, // ?: Formato de extension a buscar ...
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env' ,
                            'env'
                        ],
                    }
                },
                exclude: /node_modules/, // ?: Exclusion de Carpeta ...
            },
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader','sass-loader'], // !: Carga el uso del loader del plugin para css y sass ...
                exclude: [
                    path.resolve(__dirname, "/node_modules/")
                ]
            },
            {
                test: /\.(jpe?g|png|gif|svg|webp)$/i,
                use: [
                    {
                      loader: 'file-loader',
                      options: {
                        outputPath: 'assets/img', // !: Carpeta de salida
                        name : '[name].[ext]'
                      }
                    }
                ],
                exclude: [
                    path.resolve(__dirname, "/node_modules/")
                ]
            },
            {
                test: /\.vue$/,
                loader : 'vue-loader'
            },
            {
                test: /\.s(c|a)ss$/,
                use: [
                  'vue-style-loader',
                  'css-loader',
                  {
                    loader: 'sass-loader',
                    // Requires sass-loader@^7.0.0
                    options: {
                      implementation: require('sass'),
                      fiber: require('fibers'),
                      indentedSyntax: true // optional
                    },
                    // Requires sass-loader@^8.0.0
                    options: {
                      implementation: require('sass'),
                      sassOptions: {
                        fiber: require('fibers'),
                        indentedSyntax: true // optional
                      }
                    }
                  }
                ]
              }
        ]
    },
    resolve: {
        alias: {
          vue: 'vue/dist/vue.js'
        },
        extensions: ["*", ".js", ".vue", ".json"],
      },
};