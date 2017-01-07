# moodle_tools

# This is a work in progress

- Helps layout plugin template
- Currently only supports blocks

h3. To run
- Set up config.php - an example can be found on config-dist.php

h3. Run from terminal
- php init.php -f moodle_project_foder plugin_type plugin_name
- e.g. php init.php -f myproject_dev block my_block

h3. Run from terminal (not windows base)
- php init.php moodle_project_foder plugin_type plugin_name
- e.g. php init.php myproject_dev block my_block


h3. To copy theme
- Run from terminal
- php theme.php project theme_source theme_new
- eg php theme.php myproject_dev client1 awesome

