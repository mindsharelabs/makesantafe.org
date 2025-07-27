import gulp from "gulp";

import dartSass from 'sass'
import gulpSass from 'gulp-sass'
const sass = gulpSass(dartSass);

import sourcemaps from 'gulp-sourcemaps';
import {deleteAsync} from 'del';

gulp.task('theme-styles', () => {
    return gulp.src('sass/style.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        outputStyle: 'compressed'//nested, expanded, compact, compressed
      }).on('error', sass.logError))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./css/'))
});


gulp.task('admin-styles', () => {
    return gulp.src('sass/admin.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        outputStyle: 'compressed'//nested, expanded, compact, compressed
      }).on('error', sass.logError))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./css/'))
});

//
// gulp.task('404-styles', () => {
//     return gulp.src('sass/404-styles.scss')
//       .pipe(sourcemaps.init())
//       .pipe(sass({
//         outputStyle: 'compressed'//nested, expanded, compact, compressed
//       }).on('error', sass.logError))
//       .pipe(sourcemaps.write('.'))
//       .pipe(gulp.dest('./css/'))
// });

gulp.task('clean', () => {
    return deleteAsync([
        'inc/css/theme-styles.css',
        'inc/css/admin-styles.css',
    ]);
});

gulp.task('watch', () => {
  gulp.watch('sass/*.scss', (done) => {
    gulp.series(['theme-styles', 'admin-styles'])(done);
  });
});

gulp.task('default', gulp.series(['clean', 'theme-styles', 'admin-styles', 'watch']));
