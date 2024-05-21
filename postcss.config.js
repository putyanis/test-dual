const AtImport = require("postcss-import");
const csso = require("postcss-csso");

module.exports = {
    plugins : [
        AtImport(),
        csso({
            comments : false
        }),
    ],
};
