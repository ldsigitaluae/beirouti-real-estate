import { createFileRoute } from "@tanstack/react-router";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "Solara Bay Real Estate | Dubai Property Advisory" },
      {
        name: "description",
        content:
          "Dubai property, thoughtfully advised. Clear facts, honest guidance and support at every step.",
      },
      { property: "og:title", content: "Solara Bay Real Estate | Thoughtful Dubai Property Advice" },
      {
        property: "og:description",
        content:
          "Dubai property, thoughtfully advised. Clear facts and honest guidance from a team you can trust.",
      },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: Index,
});

function Index() {
  return (
    <main className="h-screen w-full overflow-hidden bg-background">
      <iframe
        className="h-full w-full border-0"
        src="/solara/index.html?v=3.0.1"
        title="Solara Bay Real Estate website preview"
      />
    </main>
  );
}
