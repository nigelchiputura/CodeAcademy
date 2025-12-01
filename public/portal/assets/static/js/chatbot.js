document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("chatbotToggle");
  const closeBtn = document.getElementById("chatbotClose");
  const windowEl = document.getElementById("chatbotWindow");
  const messagesEl = document.getElementById("chatbotMessages");
  const formEl = document.getElementById("chatbotForm");
  const inputEl = document.getElementById("chatbotInput");

  if (!toggleBtn || !windowEl || !formEl) return;

  const scrollToBottom = () => {
    messagesEl.scrollTop = messagesEl.scrollHeight;
  };

  const addMessage = (text, type) => {
    const div = document.createElement("div");
    div.classList.add(type === "user" ? "user-msg" : "bot-msg");
    div.textContent = text;
    messagesEl.appendChild(div);
    scrollToBottom();
  };

  toggleBtn.addEventListener("click", () => {
    windowEl.classList.toggle("open");
    if (windowEl.classList.contains("open")) {
      inputEl.focus();
    }
  });

  closeBtn.addEventListener("click", () => {
    windowEl.classList.remove("open");
  });

  formEl.addEventListener("submit", async (e) => {
    e.preventDefault();
    const msg = inputEl.value.trim();
    if (!msg) return;

    addMessage(msg, "user");
    inputEl.value = "";
    inputEl.focus();

    // Optional typing indicator
    const typing = document.createElement("div");
    typing.classList.add("bot-msg");
    typing.textContent = "Typing...";
    messagesEl.appendChild(typing);
    scrollToBottom();

    try {
      const formData = new FormData(formEl);
      const res = await fetch("/chatbot.php", {
        method: "POST",
        body: formData,
      });

      const data = await res.json();
      messagesEl.removeChild(typing);

      if (data.error) {
        addMessage("Oops, something went wrong. Please try again.", "bot");
      } else {
        addMessage(data.answer, "bot");
      }
    } catch (err) {
      messagesEl.removeChild(typing);
      addMessage("Network error. Please try again.", "bot");
      console.error(err);
    }
  });
});
