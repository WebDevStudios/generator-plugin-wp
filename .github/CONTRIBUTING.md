# Testing Your Changes

To test `yo plugin-wp` using any changes you've made, while in the repo
folder, run `npm link` and NPM will know to use `yo plugin-wp` using the code
and templates from the repo.

To get back to the official NPM `plugin-wp` command, do:

```
npm unlink && npm install -g generator-plugin-wp
```
