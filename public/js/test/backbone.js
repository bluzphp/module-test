/**
 * Backbone + REST API example
 *
 * @todo Need to refactoring this stuff
 */

import '/vendor/jquery/jquery.js';
import 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore.js';
import 'https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone.js';
import {notify} from '/js/bluz.notify.js';


let Test = Backbone.Model.extend({
    urlRoot: '/test/rest/',
    defaults: {
        'id': null,
        'name': '',
        'email': '',
        'status': ''
    }
});

let TestCollection = Backbone.Collection.extend({
    model: Test,
    url: '/test/rest/',
    page: 1,
    pages: 1,
    offset: 0,
    limit: 10,
    total: 0
});

let testList = new TestCollection();

let TestView = Backbone.View.extend({
    // ... is a list tag.
    tagName: 'li',
    className: 'list-group-item',
    // Cache the template function for a single item.
    template: _.template($('#item-template').html()),
    // The DOM events specific to an item.
    events: {
        'click .view': 'edit',
        'click a.destroy': 'clear',
        'keypress .edit': 'updateOnEnter',
        'blur .edit': 'close'
    },
    // The TodoView listens for changes to its model, re-rendering. Since there's
    // a one-to-one correspondence between a **Todo** and a **TodoView** in this
    // app, we set a direct reference on the model for convenience.
    initialize: function () {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'destroy', this.remove);
    },
    // Re-render the titles of the todo item.
    render: function () {
        this.$el.html(this.template(this.model.toJSON()));
        this.input = this.$('.edit');
        return this;
    },
    // Switch this view into `"editing"` mode, displaying the input field.
    edit: function () {
        this.$el.addClass('editing');
        this.input.focus();
    },
    // Close the `"editing"` mode, saving changes
    close: function () {
        let value = this.input.val();
        if (!value) {
            this.clear();
        } else {
            this.model.save(
                {
                    name: value
                },
                {
                    error: (model, response) => {
                        notify.addError(response.responseJSON.error);
                    },
                    success: () => {
                        notify.addNotice('Record updated');
                        this.$el.removeClass('editing');
                    }
                }
            );
        }
    },
    // If you hit `enter`, we're through editing the item.
    updateOnEnter: function (e) {
        if (e.keyCode === 13) {
            this.$el.removeClass('editing');
            this.close();
        }
    },
    // Remove the item, destroy the model.
    clear: function () {
        this.model.destroy();
    }
});
// Our overall **AppView** is the top-level piece of UI.
let AppView = Backbone.View.extend({
    // Instead of generating a new element, bind to the existing skeleton of
    // the App already present in the HTML.
    el: $('#testapp'),
    // Our template for the line of statistics at the bottom of the app.
    pagerTemplate: _.template($('#pager-template').html()),
    // Delegated events for creating new items, and clearing completed ones.
    events: {
        'submit #create-form': 'createOnEnter',
        'click #clear-completed': 'clearCompleted',
        'click #toggle-all': 'toggleAllComplete',
        'click #footer a': 'fetchPage'
    },
    // At initialization we bind to the relevant events on the `Todos`
    // collection, when items are added or changed. Kick things off by
    // loading any preexisting todos that might be saved in *localStorage*.
    initialize: function () {
        this.inputName = this.$('#create-form input[name=name]');
        this.inputEmail = this.$('#create-form input[name=email]');
        this.inputStatus = this.$('#create-form input[name=status]');
        this.listenTo(testList, 'add', this.addOne);
        this.listenTo(testList, 'reset', this.addAll);
        this.listenTo(testList, 'all', this.render);
        this.main = this.$('#main');
        this.footer = this.$('#footer');
        testList.fetch({
            error: (collection, response) => {
                notify.addError(response.responseJSON.error);
            },
            success: function (collection, response, options) {
                // items 0-10/99
                let range = options.xhr.getResponseHeader('Content-Range');
                if (range) {
                    // items, 0, 10, 99
                    range = range.split(/[ -/]/);
                    testList.total = range[3];
                } else {
                    testList.total = collection.length;
                }
                testList.pages = Math.ceil(testList.total / testList.limit);
            },
            data: {offset: testList.offset, limit: testList.limit},
            headers: {Range: 'items=' + testList.offset + '-' + (testList.offset + testList.limit)},
            reset: true,
            remove: true
        });
    },
    // Re-rendering the App just means refreshing the pagination -- the rest
    // of the app doesn't change.
    render: function () {
        if (testList.length) {
            this.main.show();
            this.footer.show();
            this.footer.html(this.pagerTemplate({model: testList}));
        } else {
            this.main.hide();
            this.footer.hide();
        }
    },
    // Add a single todo item to the list by creating a view for it, and
    // appending its element to the `<ul>`.
    addOne: function (row) {
        let view = new TestView({model: row});
        this.$('#test-list').append(view.render().el);
    },
    // Add all items in the **Todos** collection at once.
    addAll: function () {
        this.$('#test-list').empty();
        testList.each(this.addOne, this);
    },
    fetchPage: function (event) {
        let $target = $(event.target);
        let page = $target.data('page') ? $target.data('page') : 1;
        let offset = testList.limit * (page - 1);
        testList.fetch({
            error: (collection, response) => {
                notify.addError(response.responseJSON.error);
            },
            success: function (collection, response, options) {
                // items 0-10/99
                let range = options.xhr.getResponseHeader('Content-Range');
                if (range) {
                    // items, 0, 10, 99
                    range = range.split(/[ -/]/);
                    testList.total = range[3];
                } else {
                    testList.total = collection.length;
                }
                testList.pages = Math.ceil(testList.total / testList.limit);
                testList.page = page;
                testList.offset = offset;
            },
            data: {offset: offset, limit: testList.limit},
            reset: true,
            remove: true
        });
        return false;
    },
    // If you hit return in the main input field, create new **Test** model
    createOnEnter: function (e) {
        // create new entity
        testList.create({
            name: this.inputName.val(),
            email: this.inputEmail.val(),
            status: this.inputStatus.val()
        }, {
            wait: true,
            error: (collection, response) => {
                notify.addError(response.responseJSON.error);
            },
            success: () => {
                notify.addNotice('Record created');
                this.inputName.val('');
                this.inputEmail.val('');
            }
        });
        e.preventDefault();
    }
});

$(() => {
    // Finally, we kick things off by creating the **App**.
    new AppView();
});

