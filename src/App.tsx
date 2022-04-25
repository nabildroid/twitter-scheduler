import React, { useEffect, useState } from "react";
import * as Service from "./service";

import Dashboard from "./dashboard";
import Login from "./login";

function App() {
  const [auth, setAuth] = useState<string>(null!);

  useEffect(() => {
    setAuth(Service.auth!);
  }, []);
  if (auth == null) {
    return <span>Loading ...</span>;
  } else if (auth) {
    return <Dashboard />;
  } else {
    return <Login change={setAuth} />;
  }
}

export default App;
