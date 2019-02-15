/**
 * # Stateless Pager component
 *
 * ## Usage
 * ```
 * <Pager current={3}
 *        total={20}
 *        visiblePages={5}
 *        onPageChanged={this.handlePageChanged}
 *        titles={{
 *            first:   "First",
 *            prev:    "Prev",
 *            prevSet: "<<<",
 *            nextSet: ">>>",
 *            next:    "Next",
 *            last:    "Last"
 *        }} />
 * ```
 *
 * ## How it looks like
 * ```
 * First | Prev | ... | 6 | 7 | 8 | 9 | ... | Next | Last
 * ```
 *
 */
let React = require('react');

/**
 * ## Constants
 */
let BASE_SHIFT = 0;
let TITLE_SHIFT = 1;
let TITLES = {
  first: 'First',
  prev: '\u00AB',
  prevSet: '...',
  nextSet: '...',
  next: '\u00BB',
  last: 'Last'
};

/**
 * ## Constructor
 */
let Pager = React.createClass({
  displayName: 'Pager',
  propTypes: {
    current: React.PropTypes.number.isRequired,
    total: React.PropTypes.number.isRequired,
    visiblePages: React.PropTypes.number.isRequired,
    titles: React.PropTypes.object,

    onPageChanged: React.PropTypes.func,
    onPageSizeChanged: React.PropTypes.func
  },


  /* ========================= HANDLERS =============================*/
  handleFirstPage: function () {
    if (this.isPrevDisabled()) return;
    this.handlePageChanged(BASE_SHIFT);
  },

  handlePreviousPage: function () {
    if (this.isPrevDisabled()) return;
    this.handlePageChanged(this.props.current - TITLE_SHIFT);
  },

  handleNextPage: function () {
    if (this.isNextDisabled()) return;
    this.handlePageChanged(this.props.current + TITLE_SHIFT);
  },

  handleLastPage: function () {
    if (this.isNextDisabled()) return;
    this.handlePageChanged(this.props.total - TITLE_SHIFT);
  },

  /**
   * Chooses page, that is one before min of currently visible
   * pages.
   * @return void
   */
  handleMorePrevPages: function () {
    var blocks = this.calcBlocks();
    this.handlePageChanged(blocks.current * blocks.size - TITLE_SHIFT);
  },

  /**
   * Chooses page, that is one after max of currently visible
   * pages.
   * @return void
   */
  handleMoreNextPages: function () {
    let blocks = this.calcBlocks();
    this.handlePageChanged((blocks.current + TITLE_SHIFT) * blocks.size);
  },

  handlePageChanged: function (el) {
    let handler = this.props.onPageChanged;
    if (handler) handler(el);
  },


  /* ========================= HELPERS ==============================*/
  /**
   * Calculates "blocks" of buttons with page numbers.
   * @return Object
   */
  calcBlocks: function () {
    let props = this.props;
    let total = props.total;
    let blockSize = props.visiblePages;
    let current = props.current + TITLE_SHIFT;
    let blocks = Math.ceil(total / blockSize);
    let currBlock = Math.ceil(current / blockSize) - TITLE_SHIFT;

    return {
      total: blocks,
      current: currBlock,
      size: blockSize
    };
  },

  isPrevDisabled: function () {
    return this.props.current <= BASE_SHIFT;
  },

  isNextDisabled: function () {
    return this.props.current >= ( this.props.total - TITLE_SHIFT );
  },

  isPrevMoreHidden: function () {
    let blocks = this.calcBlocks();
    return ( blocks.total === TITLE_SHIFT )
      || ( blocks.current === BASE_SHIFT );
  },

  isNextMoreHidden: function () {
    var blocks = this.calcBlocks();
    return ( blocks.total === TITLE_SHIFT )
      || ( blocks.current === (blocks.total - TITLE_SHIFT) );
  },

  visibleRange: function () {
    let blocks = this.calcBlocks();
    let start = blocks.current * blocks.size;
    let delta = this.props.total - start;
    let end = start + ((delta > blocks.size) ? blocks.size : delta);
    return [start + TITLE_SHIFT, end + TITLE_SHIFT];
  },


  getTitles: function (key) {
    let pTitles = this.props.titles || {};
    return pTitles[key] || TITLES[key];
  },

  /* ========================= RENDERS ==============================*/
  render: function () {
    var titles = this.getTitles;

    return (
      React.createElement('nav', null,
        React.createElement('ul', {className: 'pagination'},
          React.createElement(Page, {
            className: 'btn-first-page',
            key: 'btn-first-page',
            isDisabled: this.isPrevDisabled(),
            onClick: this.handleFirstPage
          }, titles('first')),

          React.createElement(Page, {
            className: 'btn-prev-page',
            key: 'btn-prev-page',
            isDisabled: this.isPrevDisabled(),
            onClick: this.handlePreviousPage
          }, titles('prev')),

          React.createElement(Page, {
            className: 'btn-prev-more',
            key: 'btn-prev-more',
            isHidden: this.isPrevMoreHidden(),
            onClick: this.handleMorePrevPages
          }, titles('prevSet')),

          this.renderPages(this.visibleRange()),

          React.createElement(Page, {
            className: 'btn-next-more',
            key: 'btn-next-more',
            isHidden: this.isNextMoreHidden(),
            onClick: this.handleMoreNextPages
          }, titles('nextSet')),

          React.createElement(Page, {
            className: 'btn-next-page',
            key: 'btn-next-page',
            isDisabled: this.isNextDisabled(),
            onClick: this.handleNextPage
          }, titles('next')),

          React.createElement(Page, {
            className: 'btn-last-page',
            key: 'btn-last-page',
            isDisabled: this.isNextDisabled(),
            onClick: this.handleLastPage
          }, titles('last'))
        )
      )
    );
  },


  /**
   * ### renderPages()
   * Renders block of pages' buttons with numbers.
   * @param {Number[]} range - pair of [start, from], `from` - not inclusive.
   * @return {React.Element[]} - array of React nodes.
   */
  renderPages: function (pair) {
    let self = this;

    return range(pair[0], pair[1]).map(function (el, idx) {
      let current = el - TITLE_SHIFT;
      let onClick = self.handlePageChanged.bind(null, current);
      let isActive = (self.props.current === current);

      return (React.createElement(Page, {
        key: idx, isActive: isActive,
        className: 'btn-numbered-page',
        onClick: onClick
      }, el));
    });
  }
});


let Page = React.createClass({
  displayName: 'Page',
  render: function () {
    let props = this.props;
    if (props.isHidden) return null;

    let baseCss = props.className ? props.className + ' ' : '';
    let css = baseCss
      + (props.isActive ? 'active' : '')
      + (props.isDisabled ? ' disabled' : '');

    return (
      React.createElement('li', {key: this.props.key, className: css},
        React.createElement('a', {onClick: this.props.onClick}, this.props.children)
      )
    );
  }
});


function range(start, end) {
  let res = [];
  for (let i = start; i < end; i++) {
    res.push(i);
  }

  return res;
}

if (typeof module !== 'undefined') {
  module.exports = Pager;
}
