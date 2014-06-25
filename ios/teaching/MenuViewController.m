//
//  MenuViewController.m
//  teaching
//
//  Created by merlin on 13-12-18.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "MenuViewController.h"
#import "NavController.h"
#import "AppDelegate.h"





typedef NS_ENUM(NSInteger,MenuButtonIndex) {
    
    AVATAR_BTN = 280000,
    RECORD_BTN = 280001,
    ANNOUNCE_BTN = 280002,
    HOME_BTN = 280003,
    CIRCLE_BTN = 280004
    
};

@interface MenuViewController ()

@end

@implementation MenuViewController


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}
- (void)viewDidLoad
{
    NSLog(@"Menu view controller did load start");
    [super viewDidLoad];
    NSBundle *bundle = [NSBundle bundleForClass:[self class]];
    // Attempt to find a name for this application
    [self.view setBackgroundColor:[UIColor colorWithRed:22.0/255.0 green:76.0/255.0 blue:126.0/255.0 alpha:1.0]];


    UIImageView *menuline = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline.frame =CGRectMake(0, 24, 80, 2);
    [self.view addSubview: menuline];
    [menuline release];
    
    
    UIImageView *menuline1 = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline1.frame =CGRectMake(0,95,80, 2);
    [self.view addSubview: menuline1];
    [menuline1 release];
    
    UIImageView *menuline2 = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline2.frame =CGRectMake(0,166,80, 2);
    [self.view addSubview: menuline2];
    [menuline2 release];
    
    UIImageView *menuline3 = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline3.frame =CGRectMake(0,236,80, 2);
    [self.view addSubview: menuline3];
    [menuline3 release];
    
    UIImageView *menuline4 = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline4.frame =CGRectMake(0,307,80, 2);
    [self.view addSubview: menuline4];
    [menuline4 release];

    UIImageView *menuline5 = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"menuline"]];
    menuline5.frame =CGRectMake(0,378,80, 2);
    [self.view addSubview: menuline5];
    [menuline5 release];

    //用户图标
    UIImageView *avatar = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"avatar"]];
    avatar.frame =CGRectMake(26,38,23, 24);
    [self.view addSubview: avatar];
    [avatar release];
    //用户中心文字
    NSString *hiLabelStr = [bundle objectForInfoDictionaryKey:@"APP_TITLE_USER_CENTER"];
    //NSLog(appName);
    UILabel *hilabel = [[UILabel alloc]initWithFrame:CGRectMake(2,74,76,15)];
    hilabel.font = [UIFont systemFontOfSize:10];
    hilabel.text = hiLabelStr;
    hilabel.textColor = [UIColor whiteColor];
    hilabel.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:hilabel];
    [hilabel release];
    //透明按钮
    UIButton *avatarBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    avatarBtn.frame = CGRectMake(0, 24, 80, 80);
    avatarBtn.tag = AVATAR_BTN;
    [avatarBtn addTarget:self action:@selector(menuClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:avatarBtn];
    //[avatarBtn release];
    

    

    //UIImageView *recordicon = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"recordicon"]];
    //recordicon.frame =CGRectMake(25,111,30,28);
    //[self.view addSubview: recordicon];
    //[recordicon release];
    
    UIButton *recordicon = [UIButton buttonWithType:UIButtonTypeCustom];
    [recordicon setBackgroundImage:[UIImage imageNamed:@"recordicon"] forState:UIControlStateNormal];
    recordicon.frame =CGRectMake(25,111,30,28);
    recordicon.tag = RECORD_BTN;
    [recordicon addTarget:self action:@selector(menuClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview: recordicon];
    
    UILabel *recordtit = [[UILabel alloc]initWithFrame:CGRectMake(2,147,76,15)];
    recordtit.font = [UIFont systemFontOfSize:10];
    NSString *recordLabelStr = [bundle objectForInfoDictionaryKey:@"APP_TITLE_MY_COURSES"];
    recordtit.text = recordLabelStr;
    recordtit.textColor = [UIColor whiteColor];
    recordtit.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:recordtit];
    [recordtit release];
    

    //UIImageView *annicon = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"announce"]];
    //annicon.frame =CGRectMake(25,184,29,26);
    //[self.view addSubview: annicon];
    //[annicon release];

    UIButton *annicon = [UIButton buttonWithType:UIButtonTypeCustom];
    [annicon setBackgroundImage:[UIImage imageNamed:@"announce"] forState:UIControlStateNormal];
    annicon.frame =CGRectMake(25,184,29,26);
    annicon.tag = ANNOUNCE_BTN;
    [annicon addTarget:self action:@selector(menuClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview: annicon];
    
    UILabel *anntit = [[UILabel alloc]initWithFrame:CGRectMake(2,213,70,15)];
    anntit.font = [UIFont systemFontOfSize:10];
    NSString *anntitLabelStr = [bundle objectForInfoDictionaryKey:@"APP_TITLE_MSG"];
    anntit.text = anntitLabelStr;
    anntit.textColor = [UIColor whiteColor];
    anntit.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:anntit];
    [anntit release];
    

    //UIImageView *homeicon = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"homeicon"]];
    //homeicon.frame =CGRectMake(25,251,28,28);
    //[self.view addSubview: homeicon];

    UIButton *homeicon = [UIButton buttonWithType:UIButtonTypeCustom];
    [homeicon setBackgroundImage:[UIImage imageNamed:@"homeicon"] forState:UIControlStateNormal];
    homeicon.frame =CGRectMake(25,251,28,28);
    homeicon.tag = HOME_BTN;
    [homeicon addTarget:self action:@selector(menuClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview: homeicon];
    //[homeicon release];
    
    UILabel *hometit = [[UILabel alloc]initWithFrame:CGRectMake(2,280,70,15)];
    hometit.font = [UIFont systemFontOfSize:10];
    NSString *hometitLabelStr = [bundle objectForInfoDictionaryKey:@"APP_TITLE_DISCOVER"];
    hometit.text = hometitLabelStr;
    hometit.textColor = [UIColor whiteColor];
    hometit.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:hometit];
    [hometit release];

    UIButton *circleBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    [circleBtn setBackgroundImage:[UIImage imageNamed:@"circleicon.png"] forState:UIControlStateNormal];
    circleBtn.frame = CGRectMake(25, 323, 28, 28);
    circleBtn.tag = CIRCLE_BTN;
    [circleBtn addTarget:self action:@selector(menuClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:circleBtn];

    UILabel *circletit = [[UILabel alloc]initWithFrame:CGRectMake(2,355,70,15)];
    circletit.font = [UIFont systemFontOfSize:10];
    NSString *circletitLabelStr = [bundle objectForInfoDictionaryKey:@"APP_TITLE_CIRCLE"];
    circletit.text = circletitLabelStr;
    circletit.textColor = [UIColor whiteColor];
    circletit.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:circletit];
    [circletit release];
    
    NSLog(@"Menu view controller did load end");

}

- (void)menuClicked:(id)sender
{
    NSLog(@"menu clicked");
    DDMenuController *menuController = (DDMenuController*)((AppDelegate*)[[UIApplication sharedApplication] delegate]).menuController;
    
    UIButton *btn = (UIButton *)sender;
    
    if(btn.tag == AVATAR_BTN)
    {
        
        
        ProfileViewController *ctl = [[ProfileViewController alloc] init];
        NavController *nav = [[NavController alloc]initWithRootViewController:ctl];
        [menuController setRootController:nav animated:YES];
        
        
        [ctl release];
    }
    else if(btn.tag == RECORD_BTN)
    {
        CourseLogsViewController *ctl  = [[CourseLogsViewController alloc] init];
        NavController *nav = [[NavController alloc]initWithRootViewController:ctl];

        [menuController setRootController:nav animated:YES];

        [ctl release];
    }
    else if(btn.tag == ANNOUNCE_BTN)
    {
        AnnounceViewController *ctl  = [[AnnounceViewController alloc] init];
        NavController *nav = [[NavController alloc]initWithRootViewController:ctl];
        
        [menuController setRootController:nav animated:YES];
        
        [ctl release];
    }
    else if(btn.tag == HOME_BTN)
    {
        HomeViewController *ctl  = [[HomeViewController alloc] init];
        NavController *nav = [[NavController alloc]initWithRootViewController:ctl];
        
        [menuController setRootController:nav animated:YES];
        
        [ctl release];

    }
    else if(btn.tag == CIRCLE_BTN)
    {
        CircleViewController *ctl = [[CircleViewController alloc] init];
        NavController *nav = [[NavController alloc] initWithRootViewController:ctl];
        [menuController setRootController:nav animated:YES];
        [ctl release];
    }
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
