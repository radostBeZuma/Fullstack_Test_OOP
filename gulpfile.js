const {src, dest, watch, series} = require('gulp');
var del = require('del');
const sass = require('gulp-sass')(require('sass'));
const bulk = require('gulp-sass-bulk-importer');
const prefixer = require('gulp-autoprefixer');
const clean = require('gulp-clean-css');
const concat = require('gulp-concat');
const map = require('gulp-sourcemaps');
const plumber = require('gulp-plumber'); // модуль для отслеживания ошибок
const rigger = require('gulp-rigger'); // модуль для импорта содержимого одного файла в другой
const uglify = require('gulp-uglify'); // модуль для минимизации JavaScript
const ttf2woff = require('gulp-ttf2woff');

var path = {
    build: {
        css: 'project/webroot/assets/build/css/',
        js: 'project/webroot/assets/build/js/',
        img: 'project/webroot/assets/build/img/',
    },
    src: {
        sass: 'project/webroot/assets/src/scss/main.scss',
        js: 'project/webroot/assets/src/js/main.js',
        img: 'project/webroot/assets/src/img/**/*.*'
    }
};

function style() {
    return src(path.src.sass)
        .pipe(map.init())
        .pipe(bulk()) // проводим код через плагин, который ползволяет использовать директиву @include в scss для директорий, а не только для отдельных файлов
        .pipe(sass({
            includePaths: ['node_modules'],
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(prefixer({
            overrideBrowserslist: ['last 8 versions'],
            browsers: [
                'Android >= 4',
                'Chrome >= 20',
                'Firefox >= 24',
                'Explorer >= 11',
                'iOS >= 6',
                'Opera >= 12',
                'Safari >= 6',
            ],
        }))
        .pipe(clean({
            level: 2
        }))
        .pipe(concat('style.min.css'))
        .pipe(map.write('../sourcemaps/css/'))
        .pipe(dest(path.build.css))
}

function js() {
    return src(path.src.js) // получим файл main.js
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(rigger()) // импортируем все указанные файлы в main.js
        .pipe(concat('main.min.js'))
        .pipe(map.init())
        .pipe(uglify()) // минимизируем js
        .pipe(map.write('../sourcemaps/js/'))
        .pipe(dest(path.build.js)) // положим готовый файл
}

function fonts() {
    return src('project/webroot/assets/src/fonts/*.ttf')
        .pipe(ttf2woff())
        .pipe(dest('project/webroot/assets/build/fonts/'))
}

function cleanImg() {
    return del(path.build.img);
}

function img() {
    return src(path.src.img)
        .pipe(dest(path.build.img))
}

exports.style = style;
exports.js = js;
exports.fonts = fonts;
exports.img = series(cleanImg, img);

exports.default = function() {
    watch('project/webroot/assets/src/scss/*.scss', style);
    watch('project/webroot/assets/src/scss/**/*.scss', style);
    watch('project/webroot/assets/src/js/*.js', js);
};