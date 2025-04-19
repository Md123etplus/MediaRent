<button 
  x-data="{ darkMode: $persist(false) }"
  @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark')"
  class="p-2 rounded-md bg-gray-100 dark:bg-gray-800"
>
    <template x-if="!darkMode">
        <!-- Moon icon -->
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" stroke="currentColor" stroke-width="2"/>
        </svg>
    </template>
    <template x-if="darkMode">
        <!-- Sun icon -->
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/>
            <path d="M12 2v2M12 20v2m4.93-4.93l1.41 1.41M4.93 4.93l1.41 1.41M2 12h2M20 12h2m-4.93 4.93l-1.41 1.41M4.93 19.07l-1.41 1.41" stroke="currentColor" stroke-width="2"/>
        </svg>
    </template>
</button>