# Renamer

[![Build Status](https://travis-ci.org/gergoerdosi/renamer.svg?branch=master)](https://travis-ci.org/gergoerdosi/renamer)

Renamer is a batch file renaming tool that allows you to rename lots of files quickly and conveniently.

## Usage

The tool provides two commands, `rename` and `validate`.

### Rename command

```bash
renamer:rename <config>
```

Arguments:
* `config`: The location of the config file.

See [Configuration](#configuration) for more details.

### Validate command

```bash
renamer:validate <config>
```

## Configuration

Options:
* `root`: The directory to use as the root for the patterns.
* `renamers`: Array of renamer configurations.
  * `pattern`: The glob pattern that specifies the paths to be renamed.
  * `actions`: Array of actions to be applied to paths.
    * `name`: The name of the action. See [Actions](#actions) for available names.
    * `options`: Options array for the action.
* `validators`: Array of validator configuration.
  `pattern`:

Example:

```yaml
---
root: "/Downloads"
renamers:
- pattern: "/Images/*.jpg"
  actions:
  - name: DropName
    options: {}
  - name: AddNumber
    options: {}
validators:
- pattern: "/Images/*.jpg"
  actions:
  - name: validate
    options:
      pattern: "/^\\w+_\\d{4}\\.jpg$/"
```

## Actions

Available actions:
* `AddDirectoryName`: Adds directory name to the filename.
* `AddNumber`: Adds incremented number to the filename.
* `DropName`: Drops the filename.
