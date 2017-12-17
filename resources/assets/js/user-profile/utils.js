import React, { Component } from 'react';
import {FormGroup, Label, Input} from 'reactstrap';


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

export default TextField;
