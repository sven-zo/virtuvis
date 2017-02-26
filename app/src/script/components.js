
Vue.component('fish-menu-button', {
    props: ['text', 'icon'],
    template: '<div>{{ text }}</div>'
});

Vue.component('fish-menu-round-button', {
    props: ['status', 'text'],
    template: '<div>{{ text }}</div>'
});

Vue.component('fish-menu', {
    props: ['left', 'middle', 'right', 'left-icon', 'middle-status', 'right-icon'],
    template:
    '<div class="fish-menu-rectangle">' +
    '<fish-menu-button :text="left"></fish-menu-button>' +
    '<fish-menu-round-button :text="middle"></fish-menu-round-button>' +
    '<fish-menu-button :text="right"></fish-menu-button>' +
    '</div>'
});