/**
 * React + REST API example
 *
 * @todo integrate http://react-bootstrap.github.io/
 */

import 'https://unpkg.com/react@17/umd/react.development.js';
import 'https://unpkg.com/react-dom@17/umd/react-dom.development.js';

import '../vendor/jquery/jquery.js';
import {notify} from '/js/bluz.notify.js';
import {modal} from '/js/bluz.modal.js';


/**
 * Table Row
 */
class TableRow extends React.Component {
    handleClickEdit(e) {
        e.preventDefault();
        this.props.onClickEdit(this.props.id);
    }

    handleClickDelete(e) {
        e.preventDefault();
        if (confirm("Are you sure want to delete this record?")) {
            this.props.onClickDelete(this.props.id);
        }
    }

    render() {
        console.log('TableRow.render', this.props);
        return <tr>
            <td>
                {this.props.name}
            </td>
            <td>
                {this.props.email}
            </td>
            <td>
                {this.props.status}
            </td>
            <td>
                <button type="button" className="btn btn-light" onClick={this.handleClickEdit}>
                    <i className="bi bi-pencil"></i>
                </button>
                &nbsp;
                <button type="button" className="btn btn-danger" onClick={this.handleClickDelete}>
                    <i className="bi bi-trash"></i>
                </button>
            </td>
        </tr>;
    }
}

/**
 * Table Body
 */
class TableBody extends React.Component {
    render() {
        console.log('TableBody.render', this.props);
        let rowNodes = this.props.data?.map(function (row, i) {
            return (
                <TableRow key={row.id} id={row.id} name={row.name} email={row.email} status={row.status}
                          onClickEdit={this.props.onClickEdit} onClickDelete={this.props.onClickDelete}/>
            );
        }.bind(this));

        return (
            <tbody>
            {rowNodes}
            </tbody>
        );
    }
}

/**
 * Table
 */
class TableGrid extends React.Component {
    render() {
        console.log('TableGrid.render', this.props);
        return (
            <table className="table grid">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <TableBody data={this.props.data} onClickEdit={this.props.onClickEdit}
                           onClickDelete={this.props.onClickDelete}/>
            </table>
        );
    }
}

/**
 * Input Text Component
 */
class TextInput extends React.Component {
    render() {
        let error = this.props.error ? (
            <span className="error">{this.props.error}</span>
        ) : null;

        return (
            <div className={error ? 'form-group has-error' : 'form-group'}>
                <label className="col-sm-2 col-form-label" htmlFor={'id-' + this.props.name}>
                    {this.props.title}
                </label>
                <div className="col-sm-10">
                    <input type="text" name={this.props.name} id={'id-' + this.props.name}
                           className="form-control" placeholder={this.props.description}
                           value={this.props.value}
                           onClick={this.props.onClick}
                           onChange={this.props.onChange}/>
                    {error}
                </div>
            </div>
        );
    }
}

/**
 * Input Select Component
 */
class SelectInput extends React.Component {
    render() {
        let error = this.props.error ? (
            <span className="error">{this.props.error}</span>
        ) : null;

        return (
            <div className={error ? 'form-group has-error' : 'form-group'}>
                <label className="col-sm-2 col-form-label" htmlFor={'id-' + this.props.name}>{this.props.title}</label>
                <div className="col-sm-10">
                    <select name={this.props.name} id={'id-' + this.props.name}
                            className="form-control"
                            value={this.props.value}
                            onChange={this.props.onChange}>
                        {this.props.children}
                    </select>
                    {error}
                </div>
            </div>
        );
    }
}

/**
 * Create and Edit Form
 */
class Form extends React.Component {
    handleChange(e) {
        e.preventDefault();

        let input = {};
        input[e.target.name] = e.target.value;

        this.props.onEdit(input);
    }
    handleClick(e) {
        e.preventDefault();
    }
    handleSubmit(e) {
        e.preventDefault();

        let form = e.target;
        let id = form.elements['id'].value;

        let name = form.elements['name'].value;
        if (!name) {
            // TODO: validation
            // this.refs.Name.error('Name is required');
        }

        let email = form.elements['email'].value;
        if (!email) {
            // TODO: validation
            // this.refs.Email.error('Email is required');
        }

        let status = form.elements['status'].value;

        if (!name || !email || !status) {
            return;
        }
        this.props.onSubmit({id: id, name: name, email: email, status: status});
    }
    render() {
        return (
            <div id="modal-form" className="modal fade" tabIndex={-1} role="dialog">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <form className="editForm form-horizontal" onSubmit={this.handleSubmit}>
                            <div className="modal-header">
                                <h4 className="modal-title">{this.props.id ? 'Edit' : 'Create'}</h4>
                                <button type="button" className="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                            </div>
                            <div className="modal-body">
                                <input name="id" value={this.props.id} type="hidden"/>
                                <TextInput name="name" value={this.props.name} error="" onChange={this.handleChange}
                                           onClick={this.handleClick} title="Name" description="User name"/>
                                <TextInput name="email" value={this.props.email} error="" onChange={this.handleChange}
                                           onClick={this.handleClick} title="Email" description="example@domain.com"/>
                                <SelectInput name="status" value={this.props.status} error=""
                                             onChange={this.handleChange}
                                             title="Status" description="">
                                    <option value="active">active</option>
                                    <option value="disable">disable</option>
                                    <option value="delete">delete</option>
                                </SelectInput>
                            </div>
                            <div className="modal-footer">
                                <button type="submit" className="btn btn-primary">Save</button>
                                <button type="button" className="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        );
    }
}

/**
 * Container
 */

class Container extends React.Component {
    componentDidMount() {
        console.log('Container.componentDidMount', this.props);
        this.doRead(0 /*this.props.pager.current*/);
    }
    showModal() {
        modal.show('#modal-form');
    }
    hideModal() {
        modal.hide('#modal-form');
    }
    handleCreateClick() {
        store.dispatch(createForm());
        modal.show('#modal-form');
    }
    handleClickEdit(id) {
        store.dispatch(editForm(id));
        modal.show('#modal-form');
    }
    handleClickDelete(id) {
        this.doDelete(id);
    }
    handleEdit(row) {
        store.dispatch(updateForm(row));
    }
    handleSubmit(row) {
        if (row.id === '') {
            this.doCreate(row);
        } else {
            this.doUpdate(row);
        }
        this.hideModal();
    }
    handlePageChanged(newPage) {
        store.dispatch(setPage(newPage));
        this.doRead(newPage);
    }
    /**
     * HTTP GET method
     * @param newPage
     */
    doRead(newPage) {
        /**
         * Offset for page navigation
         * @type {number}
         */
        let offset = 10  * newPage; /*this.props.pager.limit*/

        $.ajax({
            url: this.props.url + '?offset=' + offset + '&limit=' + 10, // this.props.pager.limit,
            dataType: 'json',
            cache: false,
            success: function (data, status, xhr) {
                // e.g. Content-Range:items 0-10/96
                let range = xhr.getResponseHeader("Content-Range");
                let [, , , total] = range.split(/[ -\/]/g);

                //let pages = Math.ceil(total / store.getState().pager.limit);

                // update data container and total value
                //store.dispatch(setData(data, pages));
            }.bind(this),
            error: function (xhr, status, err) {
                // notification
                notify.addError('Error: ' + err.toString());
                // console
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    /**
     * HTTP POST method
     * @param row
     */
    doCreate(row) {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            type: 'POST',
            data: row,
            success: function () {
                notify.addSuccess('Record was created');
                //store.dispatch(createRow(row));
                // this.doRead(this.props.pager.current);
            }.bind(this),
            error: function (xhr, status, err) {
                // notification
                notify.addError('Error: ' + err.toString());
                // console
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    /**
     * HTTP PUT method
     * @param row
     */
    doUpdate(row) {
        $.ajax({
            url: this.props.url + '/' + row.id,
            dataType: 'json',
            type: 'PUT',
            data: row,
            success: function () {
                notify.addSuccess('Record was update');
                store.dispatch(updateRow(row));
            }.bind(this),
            error: function (xhr, status, err) {
                // notification
                notify.addError('Error: ' + err.toString());
                // console
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    /**
     * HTTP DELETE method
     * @param id
     */
    doDelete(id) {
        $.ajax({
            url: this.props.url + '/' + id,
            dataType: 'json',
            type: 'DELETE',
            success: function () {
                notify.addSuccess('Record was removed');
                store.dispatch(deleteRow(id));
            }.bind(this),
            error: function (xhr, status, err) {
                // notification
                notify.addError('Error: ' + err.toString());
                // console
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    render() {
        return (
            <div className="Container">
                <button className="btn btn-primary" onClick={this.handleCreateClick}>Create</button>
                <hr/>
                <Form onEdit={this.handleEdit} onSubmit={this.handleSubmit}/>
                <TableGrid onClickEdit={this.handleClickEdit} onClickDelete={this.handleClickDelete}/>
                {/*<Pager onPageChanged={this.handlePageChanged}/>*/}
            </div>
        );
    }
}

/**
 * Render
 */
ReactDOM.render(
    <Container url="/test/rest"/>,
    document.getElementById('container')
);
