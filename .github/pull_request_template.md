name: Pull Request
description: Submit changes to the Oviya theme
body:
  - type: textarea
    id: description
    attributes:
      label: Description of Changes
      description: Provide a clear summary of what this pull request changes or adds.
      placeholder: Explain what your PR achieves...
    validations:
      required: true
  - type: dropdown
    id: type
    attributes:
      label: Type of Change
      description: What type of change does your code introduce?
      options:
        - Bug fix (non-breaking change which fixes an issue)
        - New feature (non-breaking change which adds functionality)
        - Breaking change (fix or feature that would cause existing functionality to change)
        - Documentation update
    validations:
      required: true
  - type: checkboxes
    id: checklist
    attributes:
      label: Checklist
      description: Confirm that you have met all development standards.
      options:
        - label: I have tested these changes locally in a WordPress environment.
          required: true
        - label: My code follows the project's coding standards.
          required: true
        - label: I have updated relevant documentation if necessary.
          required: true