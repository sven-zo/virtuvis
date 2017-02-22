//JS file for all the Vue components.

//Homepage
const home = {
    template:
        '<div>' +
        '<p>Home</p>' +
        '<router-link to="/fish">Vis</router-link>' +
        '</div>'
};

//Detail screen for the fish
const fishDetail = {
    template:
    '<div>' +
    '<p>Fish detail</p>' +
    '<router-link to="/">Ga terug</router-link>' +
    '</div>'
};

//Adding a settings screen
const settings = {
    template:
    '<div>' +
    '<p>Settings</p>' +
    '<router-link to="/">Ga terug</router-link>' +
    '</div>'
};

//Adding a fishing rod screen
const addRod = {
    template:
    '<div>' +
    '<p>Voeg hengel toe</p>' +
    '<router-link to="/">Ga terug</router-link>' +
    '</div>'
};