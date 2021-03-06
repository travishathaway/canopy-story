import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {FormGroup, Label, Input, Button} from 'reactstrap';

// Special axios with our CSRF Token added
import axios from '../axios';

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


class TextField extends Component {
  constructor(props) {
    super(props);

    this.state = {
      /**
       * Holds the value for the input field
       */
      value: props.value,
      /**
       * Holds state of form. We're interested in the 'loading' state
       * primarily for the field
       */
      form_state: props.form_state,
      /**
       * Holds the state for the field, choices are: 'edit', 'error'
       */
      field_state: 'edit'
    }
  }

  /**
   * This will update the value of the form field especially 
   * in ajax context
   */
  componentWillReceiveProps(nextProps) {
    this.setState({value: nextProps.value});
    this.setState({form_state: nextProps.form_state});
  }

  render() {
    var field_color = this.state.field_state === 'error' ? 'danger' : '';

    return (
      <FormGroup color={field_color}>
        <Label for={this.props.id}>
          <strong>{this.props.label}</strong>
        </Label>
        <Input type="text" name={this.props.id} state={field_color}
          disabled={this.state.form_state === 'loading'}
          value={this.state.value} onChange={this.props.onChange}>
        </Input>
      </FormGroup>
    )
  }
}


export default UserProfile;

// We only want to try to render our component on pages that have a div with an ID
// of "example"; otherwise, we will see an error in our console 
if (document.getElementById('user-profile')) {
    ReactDOM.render(<UserProfile />, document.getElementById('user-profile'));
}
