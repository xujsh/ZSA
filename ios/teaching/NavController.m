//
//  NavController.m
//  yeeaoo
//
//  Created by merlin on 13-10-10.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "NavController.h"

@interface NavController ()

@end

@implementation NavController

//@synthesize navTitleLable;

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
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    //UIImageView *navBar = [[UIImageView alloc]initWithImage: [UIImage imageNamed:@"toptoolbar.png"]];
    //navBar.frame = CGRectMake(0, 0, 320, 44);
    
    UIImage *navbgimg = [UIImage imageNamed:@"topbar.png"] ;
    
    #if __IPHONE_OS_VERSION_MAX_ALLOWED >= 70000
    if ( IOS7_OR_LATER )
    {
        navbgimg = [navbgimg resizableImageWithCapInsets:UIEdgeInsetsMake(0,0,20,320) resizingMode:UIImageResizingModeStretch];
        
    }
    #endif	// #if __IPHONE_OS_VERSION_MAX_ALLOWED >= 70000
    
    ;
    [self.navigationBar setBackgroundImage:navbgimg forBarMetrics:UIBarMetricsDefault];
    
    
   
    //[[UIBarButtonItem appearance] setTitleTextAttributes: [NSDictionary dictionaryWithObjectsAndKeys: [UIColor colorWithRed:255.0/255 green:255.0/255 blue:255.0/255 alpha:0.0], UITextAttributeTextColor, [UIColor colorWithRed:1.0 green:1.0 blue:1.0 alpha:0.0], UITextAttributeTextShadowColor, [NSValue valueWithUIOffset:UIOffsetMake(0,0)], UITextAttributeTextShadowOffset, [UIFont systemFontOfSize:0.0], UITextAttributeFont, nil]forState:UIControlEventTouchDown];
    
    
    navbgimg = nil;
    
}

- (void) viewWillAppear:(BOOL)animated
{
    /*
    UIImage *btnimg = [UIImage imageNamed:@"backbtn"];
    btnimg = [btnimg stretchableImageWithLeftCapWidth:27 topCapHeight:0];
    [[UIBarButtonItem appearance] setBackButtonBackgroundImage:btnimg forState:UIControlStateNormal barMetrics:UIBarMetricsDefault];
    [[UIBarButtonItem appearance] setTitleTextAttributes: [NSDictionary dictionaryWithObjectsAndKeys: [UIColor colorWithRed:255.0/255 green:255.0/255 blue:255.0/255 alpha:0.0], UITextAttributeTextColor, [UIColor colorWithRed:1.0 green:1.0 blue:1.0 alpha:0.0], UITextAttributeTextShadowColor, [NSValue valueWithUIOffset:UIOffsetMake(0, -1)], UITextAttributeTextShadowOffset, [UIFont systemFontOfSize:0.0], UITextAttributeFont, nil]forState:UIControlStateNormal];
    */
    
    [super viewWillAppear:animated];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
