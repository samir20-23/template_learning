import {Link, Outlet, useNavigate} from "react-router-dom";
import Logo from "../components/Logo.jsx";
import {LOGIN_ROUTE, redirectToDashboard, STUDENT_DASHBOARD_ROUTE} from "../router/index.jsx";
import {useEffect, useState,} from "react";
import {useUserContext} from "../context/StudentContext.jsx";
import UserApi from "../services/Api/UserApi.js";
import StudentDropDownMenu from "./drop-down-menu/StudentDropDownMenu.jsx";
import {GaugeIcon} from "lucide-react";
import {ModeToggle} from "../components/mode-toggle.jsx";
import {AdminAdministrationSideBar} from "./Administration/AdminAdministrationSideBar.jsx";
import AdminDropDownMenu from "./drop-down-menu/AdminDropDownMenu.jsx";

export default function AdminDashboardLayout() {
  const navigate = useNavigate()
  const [isLoading, setIsLoading] = useState(true)
  const {authenticated, setUser, setAuthenticated, logout: contextLogout} = useUserContext()
  useEffect(() => {
    if (authenticated === true) {
      setIsLoading(false)
      UserApi.getUser().then(({data}) => {
        const {role} = data
        if(role !== 'admin') {
          navigate(redirectToDashboard(role));
        }
        setUser(data)
        setAuthenticated(true)
      }).catch((reason) => {
        contextLogout()
      })
    } else {
      navigate(LOGIN_ROUTE)
    }

  }, [authenticated]);

  if (isLoading) {
    return <></>
  }

  return <>
    <header>
      <div
        className="items-center justify-between flex bg-opacity-90 px-12 py-4 mb-4 mx-auto">
        <div className="text-2xl text-white font-semibold inline-flex items-center">
          <Logo/>
        </div>
        <div>
          <ul className="flex text-white place-items-center">
            <li className="ml-5 px-2 py-1">
              <Link className={'flex'} to={STUDENT_DASHBOARD_ROUTE}><GaugeIcon className={'mx-1'}/>Dashboard</Link>
            </li>
            <li className="ml-5 px-2 py-1">
              <AdminDropDownMenu/>
            </li>
            <li className="ml-5 px-2 py-1">
              <ModeToggle/>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <hr/>
    <main className={'mx-auto px-10 space-y-4 py-4'}>
      <div className="flex">
        <div className={'w-full md:w-2/12 border mr-2 rounded-l'}>
          <AdminAdministrationSideBar/>
        </div>
        <div className={'w-full md:w-10/12 border rounded-l'}>
          <Outlet/>
        </div>
      </div>
    </main>
  </>
}
