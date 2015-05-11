# generator-plugin-wp Widget Subgenerator

```bash
yo plugin-wp Widget widget-name
```

Creates a skeleton widget and shortcode for your plugin.

You either need to manually require the generated widget, or remove the register function at the bottom of the include and add the `register_widget` call to your main plugin class.