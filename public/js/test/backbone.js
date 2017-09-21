/**
 * Backbone + REST API example
 *
 * @todo Need to refactoring this stuff
 */
/* global define,require */
define(['jquery', 'backbone', 'bluz.notify'], function ($, Backbone, notify) {
  $(function () {
    window.Test = Backbone.Model.extend({
      urlRoot: '/test/rest/',
      defaults: {
        'id': null,
        'name': '',
        'email': '',
        'status': ''
      }
    });
    window.TestCollection = Backbone.Collection.extend({
      model: window.Test,
      url: '/test/rest/',
      page: 1,
      pages: 1,
      offset: 0,
      limit: 10,
      total: 0
    });

    let testList = new window.TestCollection();

    window.TestView = Backbone.View.extend({
      // ... is a list tag.
      tagName: 'li',
      className: 'list-group-item',
      // Cache the template function for a single item.
      template: _.template($('#item-template').html()),
      // The DOM events specific to an item.
      events: {
        "click .view": "edit",
        "click a.destroy": "clear",
        "keypress .edit": "updateOnEnter",
        "blur .edit": "close"
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
        this.$el.addClass("editing");
        this.input.focus();
      },
      // Close the `"editing"` mode, saving changes to the todo.
      close: function () {
        var value = this.input.val();
        var $el = this.$el;
        if (!value) {
          this.clear();
        } else {
          this.model.save({
            name: value
          }, {
            error: function (model, response) {
              console.log('save error');
              notify.addError('Error: ' + response.responseJSON.error);
            },
            success: function (model, response) {
              notify.addNotice("Record updated");
              $el.removeClass("editing");
            }
          });
        }
      },
      // If you hit `enter`, we're through editing the item.
      updateOnEnter: function (e) {
        if (e.keyCode == 13) {
          // this.close();
          this.$el.removeClass("editing");
        }
      },
      // Remove the item, destroy the model.
      clear: function () {
        this.model.destroy();
      }
    });
    // Our overall **AppView** is the top-level piece of UI.
    window.AppView = Backbone.View.extend({
      // Instead of generating a new element, bind to the existing skeleton of
      // the App already present in the HTML.
      el: $("#testapp"),
      // Our template for the line of statistics at the bottom of the app.
      pagerTemplate: _.template($('#pager-template').html()),
      // Delegated events for creating new items, and clearing completed ones.
      events: {
        "submit #create-form": "createOnEnter",
        "click #clear-completed": "clearCompleted",
        "click #toggle-all": "toggleAllComplete",
        "click #footer a": "fetchPage"
      },
      // At initialization we bind to the relevant events on the `Todos`
      // collection, when items are added or changed. Kick things off by
      // loading any preexisting todos that might be saved in *localStorage*.
      initialize: function () {
        this.inputName = this.$("#create-form input[type=text]");
        this.inputEmail = this.$("#create-form input[type=email]");
        this.listenTo(testList, 'add', this.addOne);
        this.listenTo(testList, 'reset', this.addAll);
        this.listenTo(testList, 'all', this.render);
        this.main = this.$('#main');
        this.footer = this.$('#footer');
        testList.fetch({
          error: function (collection, response, options) {
            console.log('initialize error');
            notify.addError('Error: ' + response.responseJSON.error);
          },
          success: function (collection, response, options) {
            // items 0-10/99
            var range = options.xhr.getResponseHeader('Content-Range');
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
        var view = new TestView({model: row});
        this.$("#test-list").append(view.render().el);
      },
      // Add all items in the **Todos** collection at once.
      addAll: function () {
        this.$("#test-list").empty();
        testList.each(this.addOne, this);
      },
      fetchPage: function (event) {
        var $target = $(event.target);
        var page = $target.data('page') ? $target.data('page') : 1;
        var offset = testList.limit * (page - 1);
        testList.fetch({
          error: function (collection, response, options) {
            console.log('fetch page error');
            notify.addError('Error: ' + response.responseJSON.error);
          },
          success: function (collection, response, options) {
            // items 0-10/99
            var range = options.xhr.getResponseHeader('Content-Range');
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
          email: this.inputEmail.val()
        }, {
          wait: true,
          error: function (collection, response, options) {
            console.log('create error');
            notify.addError(response.responseJSON.error);
          },
          success: function (response) {
            notify.addNotice("Record created");
            this.inputName.val('');
            this.inputEmail.val('');
          }
        });
        e.preventDefault();
      }
    });
    // Finally, we kick things off by creating the **App**.
    var App = new AppView;
  });
});