/*eslint "@typescript-eslint/no-var-requires": "off" */
const path = require('path');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const IgnoreEmitPlugin = require('ignore-emit-webpack-plugin');
const RemovePlugin = require('remove-files-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');

const isDevelopment = process.env.NODE_ENV === 'development';
const keepGitIgnore = (absPath) => !absPath.match(/\/\.gitignore$/);
const cssEntries = {
  'public/css/styles': './resources/assets/sass/styles.scss',
  'public/css/datatables': './resources/assets/sass/datatables.scss',
  'public/css/magnific-popup': './resources/assets/sass/magnific-popup.scss',
  'public/css/easymde': './resources/assets/sass/easymde.scss',
  'resources/views/vendor/mail/html/themes/default': './resources/assets/sass/email.scss',
};

let webpackConfig = {
  entry: {
    ...cssEntries,
    'public/js/main': {
      import: './resources/assets/js/main.js',
    },
    'public/js/datatables': {
      import: './resources/assets/js/datatables.js',
      dependOn: 'public/js/main',
    },
    'public/js/magnific-popup': {
      import: './resources/assets/js/magnific-popup.js',
      dependOn: 'public/js/main',
    },
    'public/js/easymde': './resources/assets/js/easymde.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, './'),
    publicPath: '/',
  },
  target: 'browserslist',
  resolve: {
    extensions: ['.ts', '.tsx', '.js', '.jsx', '.json'],
  },
  devtool: isDevelopment ? 'inline-source-map' : 'source-map',
  stats: {
    children: false,
    chunks: false,
    colors: true,
    depth: true,
    env: true,
    modules: false,
    reasons: true,
  },
  optimization: {
    minimizer: isDevelopment
      ? undefined
      : [
          new TerserJSPlugin({}),
          new OptimizeCSSAssetsPlugin({
            assetNameRegExp: /(?<!default)\.css$/g,
            cssProcessorOptions: {
              map: { inline: false, annotation: true },
            },
          }),
        ],
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          { loader: 'css-loader', options: { sourceMap: true, url: false, importLoaders: 2 } },
          { loader: 'postcss-loader', options: { sourceMap: true } },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
              sassOptions: { implementation: require('sass'), outputStyle: 'expanded' },
            },
          },
        ],
      },
    ],
  },
  plugins: [
    // MiniCssExtractPlugin produces for every CSS file also JS file, this will prevent from saving them
    new IgnoreEmitPlugin(
      [
        ...Object.keys(cssEntries).map((entry) => new RegExp('^' + entry.replace('/', '\\/') + '\\.js(\\.map)?$')),
        /resources\/views\/vendor\/mail\/html\/themes\/default\.css\.map/,
      ],
      { debug: true }
    ),
    new CopyPlugin({
      patterns: [
        {
          from: 'fa-solid-*',
          to: './public/fonts/',
          context: path.resolve(__dirname, './node_modules/@fortawesome/fontawesome-free/webfonts/'),
        },
      ],
    }),
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new RemovePlugin({
      before: {
        test: [
          { folder: './public/css', method: keepGitIgnore },
          { folder: './public/js', method: keepGitIgnore },
          { folder: 'resources/views/vendor/mail/html/themes', method: keepGitIgnore },
          { folder: './public/fonts/', method: () => true },
        ],
      },
    }),
    new WebpackManifestPlugin({
      fileName: 'public/mix-manifest.json',
      basePath: '/',
      filter: function (file) {
        if (file.name.match(/mail\/html\/themes\/default\.css(\.map)?$/)) {
          return false;
        }
        return file.isChunk;
      },
      map: function (file) {
        const hash = file.chunk && file.chunk.renderedHash;
        file.name = file.name.replace(/^\/public/, '');
        file.path = file.path.replace(/^\/public/, '') + (hash ? '?v=' + hash : '');

        return file;
      },
    }),
  ],
};

module.exports = webpackConfig;
