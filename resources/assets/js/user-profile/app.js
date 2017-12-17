import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {FormGroup, Label, Button} from 'reactstrap';

// Special axios with our CSRF Token added
import axios from '../axios';

import TextField from './utils';


class UserProfile extends Component {
  constructor(){
    super()

    this.text_fields = [
      {id: 'first_name', label: window.UserProfile.trans['first_name']},
      {id: 'last_name', label: window.UserProfile.trans['last_name']},
      {id: 'email', label: window.UserProfile.trans['email']},
    ];

    this.state = {
      /**
       * Holds user profile data to view/edit
       */
      resource_data: {},
      /**
       * Holds form copy of data
       */
      resource_form_data: {},
      /**
       * Controls the layout of profile, 'view', 'edit', or 'loading'
       */
      form_state: 'view',
      /**
       * Holds an error message about the form submission
       */
      form_error_message: ''
    }

    /**
     * Bind change events
     */
    this.handleChange = this.handleChange.bind(this);

    var self = this;

    axios.get(
      window.UserProfile.user_resource_url
    ).then(function(resp){
      self.updateResourceState(resp.data);
    });
  }

  toggleProfileState(){
    if(this.state.form_state === 'edit'){
      this.setState({form_state: 'view'});
    } else {
      this.setState({form_state: 'edit'});
    }
  }

  handleChange(e) {
    const name = e.target.name;
    const value = e.target.value;

    var resource_form_data = this.state.resource_form_data;
    resource_form_data[name] = value;

    this.setState({resource_form_data})
  }

  updateResourceState(data){
    this.setState({resource_data: Object.assign({}, data)});
    this.setState({resource_form_data: Object.assign({}, data)});
  }

  /**
   * Saves the resource by submitting a post to our resource API
   */
  save() {
    self = this;
    this.setState({form_state: 'loading'});

    axios.post(
      window.UserProfile.user_resource_url,
      {user: this.state.resource_form_data}
    ).then(function(resp){
      self.updateResourceState(resp.data);
      self.setState({form_error_message: ''});
      self.setState({form_state: 'view'});

    }).catch(function(error){
      if(error.response){
        self.setState({form_state: 'edit'});
        self.setState({form_error_message: error.response.data.message});
      }
    });
  }

  /**
   * Cancels the current updating of record
   */
  cancel() {
    this.setState({
      resource_form_data: Object.assign({}, this.state.resource_data)
    });
    this.setState({form_state: 'view'});
    this.setState({form_error_message: ''});
  }

  render() {
    self = this;
    var user = this.state.resource_form_data;
    var form_state = this.state.form_state;
    var form_error_message = this.state.form_error_message;

    /**
     * Depending on the form_state, show either a form or a
     * textual representation
     */
    if( form_state === 'edit' || form_state === 'loading' ){
      var fields = this.text_fields.map(function(field) {
        return (
          <TextField id={field.id} label={field.label} form_state={self.state.form_state}
            value={user[field.id]} key={field.id} onChange={self.handleChange}>
          </TextField>
        )
      });
    } else {
      var fields = this.text_fields.map(function(field) {
        return (
          <div key={field.id}>
            <Label for={field.id}>
              <strong>{field.label}</strong>
            </Label>
            <p>{user[field.id]}</p>
          </div>
        )
      });
    }

    return (
      <div>
        <div className="pull-right">
          {form_state === 'view' && 
            <Button color="secondary" onClick={this.toggleProfileState.bind(this)}>
            {window.UserProfile.trans['edit']}
            </Button>
          }
        </div>
        {form_error_message !== '' &&
        <div className="alert alert-danger" role="alert">
          {form_error_message}
        </div>
        }
        {fields}
        {(form_state === 'edit' || form_state === 'loading') && 
          <div className="d-flex justify-content-end">
            <Button color="secondary" 
              onClick={this.cancel.bind(this)}
              disabled={form_state === 'loading'}
            >
              {window.UserProfile.trans['cancel']}
            </Button>
            <Button color="primary" className="ml-2" 
              onClick={this.save.bind(this)}
              disabled={form_state === 'loading'}
            >
              {window.UserProfile.trans['save']}
            </Button>
          </div>
        }
      </div>
    );
  }
}

class UserStories extends Component {
  render(){
    return (
      <div>
        <h2>Stories</h2>
      </div>
    )
  }
}


class UserPage extends Component {

  render(){
    return (
      <div className="row">
        <div className="col-3">
          <UserProfile />
        </div>
        <div className="col-9">
          <UserStories />
        </div>
      </div>
    )
  }
}

export default UserProfile;

// We only want to try to render our component on pages that have a div with an ID
// of "example"; otherwise, we will see an error in our console 
if (document.getElementById('user-profile')) {
    ReactDOM.render(<UserPage />, document.getElementById('user-profile'));
}
