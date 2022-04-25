import axios from "axios";

axios.defaults.baseURL = "./api";

export type Tweet = {
  content: string;
  accounts: string[];
  countries: string[];
  interval: number;
  id: number;
};

export const auth = localStorage.getItem("auth") ?? "";
if (auth) {
  axios.interceptors.request.use((config) => {
    config.headers!.AUTH = auth;
    return config;
  });
}

export async function login(name: string, password: string) {
  const { data } = await axios.post("/login.php", {
    login: "login",
    username: name,
    password: password,
  });
  if (data == "error") return false;

  axios.interceptors.request.use((config) => {
    config.headers!.AUTH = data;
    return config;
  });

  localStorage.setItem("auth", data);

  return true;
}

export function logout() {
  axios.interceptors.request.use((config) => {
    config.headers!.AUTH = "";
    return config;
  });

  localStorage.setItem("auth", "");
}

export async function addTweet(tweet: Omit<Tweet, "id">) {
  const { data } = await axios.post("/index.php", {
    type: "addTweet",
    tweet,
  });

  return data;
}

export async function updateTweet(
  tweet: Partial<Omit<Tweet, "id">> & { id: Tweet["id"] }
) {
  const { data } = await axios.post("/index.php", {
    type: "updateTweet",
    tweet,
    id: tweet.id,
  });

  return data;
}

export async function deleteTweet(id: number) {
  await axios.post("/index.php", {
    type: "deleteTweet",
    id,
  });
}

export async function getTweets() {
  const { data: tweets } = await axios.post("/index.php", {
    type: "getTweets",
  });

  return tweets;
}

export async function getCountries(id: string) {
  const { data: countires } = await axios.post("/index.php", {
    type: "getCountries",
    id,
  });

  return countires;
}

export async function getAccounts() {
  const { data: accounts } = await axios.post("/index.php", {
    type: "getAccounts",
  });

  return accounts;
}
