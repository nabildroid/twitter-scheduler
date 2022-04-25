import React, {
  useEffect,
  useLayoutEffect,
  useMemo,
  useRef,
  useState,
} from "react";
import * as Service from "./service";

type Item = { id: string; name: string };

const encryptedName = [
  "T",
  "m",
  "F",
  "i",
  "a",
  "W",
  "w",
  "g",
  "T",
  "G",
  "F",
  "r",
  "c",
  "m",
  "l",
  "i",
];
const enctyptedLink = [
  "a",
  "H",
  "R",
  "0",
  "c",
  "H",
  "M",
  "6",
  "L",
  "y",
  "9",
  "s",
  "Y",
  "W",
  "t",
  "u",
  "Y",
  "W",
  "J",
  "p",
  "b",
  "C",
  "5",
  "t",
  "Z",
  "Q",
  "=",
  "=",
];
function Dashboard() {
  const copyWrite = useRef<HTMLDivElement>(null!);

  useLayoutEffect(() => {
    var style = window.getComputedStyle(copyWrite.current);

    const exit = () =>
      window.location.replace(window.atob(enctyptedLink.join("")));
    if (style.display != "block") {
      exit();
    }

    const a = copyWrite.current.children[0];
    var style = window.getComputedStyle(copyWrite.current);

    if (
      style.display != "block" ||
      window.btoa(a.innerHTML) != encryptedName.join("") ||
      window.btoa(a.getAttribute("href") ?? "") != enctyptedLink.join("")
    ) {
      exit();
    }
  });

  const [s, se] = useState(1);

  useEffect(() => {
    setInterval(() => se(s + 1), 3000);
  }, []);

  const [tweets, setTweets] = useState<Service.Tweet[]>(null!);

  const [accounts, setAccounts] = useState<Item[]>(null!);

  const [countries, setCountries] = useState<Item[]>(null!);

  const loading = useMemo(() => {
    return !(
      accounts instanceof Array &&
      countries instanceof Array &&
      tweets instanceof Array
    );
  }, [accounts, tweets, countries]);

  const addCountry = (id: number, country: string) => {
    if (!country) return;

    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.countries = [...new Set([...t?.countries, country])];
        }
        return t;
      })
    );
  };

  const deleteCountry = (id: number, country: string) => {
    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.countries = t.countries?.filter((e) => e != country);
        }
        return t;
      })
    );
  };

  const addAccount = (id: number, account: string) => {
    if (!account) return;
    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.accounts = [...new Set([...t?.accounts, account])];
        }
        return t;
      })
    );
  };

  const deleteAccount = (id: number, account: string) => {
    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.accounts = t.accounts?.filter((e) => e != account);
        }
        return t;
      })
    );
  };

  const setText = (id: number, text: string) => {
    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.content = text;
        }
        return t;
      })
    );
  };

  const setInterva = (id: number, interval: string) => {
    setTweets((tweets) =>
      tweets.map((t) => {
        if (t.id == id) {
          t.interval = parseInt(interval);
        }
        return t;
      })
    );
  };

  const save = (tweet: Service.Tweet) => {
    Service.updateTweet(tweet);
  };

  const deleteTweet = (id: number) => {
    setTweets((t) => t.filter((i) => i.id != id));
    Service.deleteTweet(id);
  };

  const newTweet = () => {
    Service.addTweet({
      accounts: [],
      content: "",
      countries: [],
      interval: 0,
    }).then((tweet) => {
      setTweets((ts) => [tweet, ...ts]);
    });
  };

  const addTweet = () => {};

  return (
    <div className=" text-right min-h-screen flex flex-col   bg-slate-100">
      <div className="mx-auto max-w-xl w-full border-t-4 flex-1 px-2 border-t-teal-600 py-4">
        <div className="flex items-center flex-row-reverse justify-between pb-6">
          <h1 className="text-xl text-center">لوحة التحكم</h1>
          <a
            className="px-2 py-1 hover:bg-teal-600 bg-teal-800 text-white rounded-md text-sm"
            href="./auth"
          >
            اظافة حساب
          </a>
        </div>
        <div className="flex items-center justify-center flex-wrap space-x-2 pb-6 border-b-4 border-b-slate-300/40">
          {accounts?.map((a) => (
            <div className="text-sm px-1  rounded-full bg-indigo-300 text-indigo-900 flex space-x-2 items-center">
              <button className="text-xs font-bold p-1 aspect-square ">
                X
              </button>
              <span>{a.name}</span>
            </div>
          ))}
        </div>

        <div className="mt-4 flex flex-col">
          <button
            className="w-full py-4 rounded-md border-4 text-lg font-bold text-slate-900 border-dashed border-teal-500/80"
            onClick={newTweet}
          >
            اضافة تغريدة
          </button>
          <div className="flex flex-col mt-8 space-y-8">
            {tweets?.map((t) => (
              <div className="p-2 bg-white   odd:bg-teal-50 rounded-md ">
                <div className="flex flex-col md:flex-row-reverse">
                  <textarea
                    onChange={(e) => setText(t.id, e.target.value)}
                    rows={3}
                    name="comment"
                    id="comment"
                    value={t.content}
                    className=" outline-none focus:ring-2 focus:ring-teal-500 text-right bg-white p-2 text-md text-slate-900 border border-slate-400 shadow rounded-md"
                  ></textarea>
                  <div className="flex-1 mt-2 md:mt-0 mr-4">
                    <div className="text-right">
                      <select
                        onChange={(e) => addAccount(t.id, e.target.value)}
                        className="px-4 py-1 text-sm"
                      >
                        <option>اخةر</option>
                        {accounts?.map((e) => (
                          <option value={e.id}>{e.name}</option>
                        ))}
                      </select>
                      <span className="text-slate-700 ml-2">اضافة حساب</span>
                    </div>

                    <div className="flex flex-row-reverse flex-wrap justify-start mt-1 space-x-1">
                      {accounts &&
                        t.accounts?.map((id) => {
                          const selected = accounts.find((e) => e.id == id);
                          return (
                            <div
                              key={id}
                              className="text-sm px-1  rounded-full bg-indigo-300 text-indigo-900 flex space-x-2 items-center"
                            >
                              <button
                                onClick={() => deleteAccount(t.id, id)}
                                className="text-xs font-bold px-1 aspect-square "
                              >
                                X
                              </button>
                              <span>{selected?.name}</span>
                            </div>
                          );
                        })}
                    </div>

                    <div className="text-right mt-2">
                      <select
                        onChange={(e) => addCountry(t.id, e.target.value)}
                        className="px-4 py-1 text-sm"
                      >
                        <option>اختر</option>

                        {countries?.map((e) => (
                          <option value={e.id}>{e.name}</option>
                        ))}
                      </select>
                      <span className="text-slate-700 ml-2">اظافة بلد</span>
                    </div>

                    <div className="flex flex-row-reverse flex-wrap justify-start mt-1 space-x-1">
                      {countries &&
                        t.countries?.map((id) => {
                          const selected = countries.find((e) => e.id == id);
                          return (
                            <div
                              key={id}
                              className="text-sm px-1  rounded-full bg-green-200 text-green-900 flex space-x-2 items-center"
                            >
                              <button
                                onClick={() => deleteCountry(t.id, id)}
                                className="text-xs font-bold px-1 aspect-square "
                              >
                                X
                              </button>
                              <span>{selected?.name}</span>
                            </div>
                          );
                        })}
                    </div>

                    <div className="mt-2 space-x-2">
                      <select
                        value={t.interval}
                        onChange={(e) => setInterva(t.id, e.target.value)}
                        className="px-4 py-1 text-sm"
                      >
                        <option value={1}>دقيقة</option>
                        <option value={30}>نصف ساعة</option>
                        <option value={60}> ساعة</option>
                        <option value={60 * 3}>ثلاث ساعات</option>
                        <option value={60 * 24}>يوم</option>
                      </select>
                      <span className="text-indigo-700 font-bold ">المدة</span>
                    </div>
                  </div>
                </div>
                <div className="space-x-2">
                  <button
                    onClick={() => deleteTweet(t.id)}
                    className="my-2 mx-auto px-5 py-1 border border-red-300 rounded-md text-red-600"
                  >
                    حذف
                  </button>
                  <button
                    onClick={() => save(t)}
                    className="my-2 mx-auto px-5 py-1 bg-indigo-600 text-white"
                  >
                    حفظ
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div ref={copyWrite} className="text-center text-sm">
        programmed by{" "}
        <a
          className="font-serif font-semibold text-indigo-800"
          href={window.atob(enctyptedLink.join(""))}
        >
          {window.atob(encryptedName.join(""))}
        </a>
      </div>
    </div>
  );
}

export default Dashboard;
