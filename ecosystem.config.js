module.exports = {
  apps: [
    {
      name: "mosche",
      exec_mode: "cluster",
      instances: "max",
      script: "./node_modules/nuxt/bin/nuxt.js",
      cwd: "./packages/frontend",
      args: "start",
    },
  ],
};
