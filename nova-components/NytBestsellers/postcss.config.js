const path = require("path");

module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
        uniquestyles: {
            paths: [
                path.join(__dirname, "../../public/vendor/nova/app.css"),
            ]
        },
    }
}
