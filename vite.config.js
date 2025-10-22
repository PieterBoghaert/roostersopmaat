import { ViteImageOptimizer } from "vite-plugin-image-optimizer";
import { defineConfig } from "vite";
import path from "path";

export default defineConfig(({ command, mode, ssrBuild }) => {
  return {
    build: {
      rollupOptions: {
        output: {
          assetFileNames: "[name][extname]",
          entryFileNames: "[name].js",
          chunkFileNames: "[name].js",
        },
        external: ["@popperjs/core"],
      },

      minify: mode === "production" ? true : false,
      lib: {
        entry: path.resolve(__dirname, "frontend_src/js/main.js"),
        fileName: "main",
        name: "main",
        formats: ["es"],
      },
    },
    outDir: "dist",
    publicDir: "frontend_src/assets",
    plugins: [ViteImageOptimizer({})],
  };
});
